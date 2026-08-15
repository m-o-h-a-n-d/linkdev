<?php

namespace App\Services\Team;

use App\Data\Team\ChangeTeamStatusData;
use App\Data\Team\CreateTeamData;
use App\Data\Team\UpdateTeamData;
use App\Mail\TeamAcceptedMail;
use App\Mail\TeamRejectedMail;
use App\Models\Team;
use App\Repositories\Contracts\Team\TeamRepositoryInterface;
use App\Utility\ActivityLogger;
use App\Utility\Enums\TeamStatus;
use App\Utility\ImageManager;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TeamService
{
    public function __construct(
        protected TeamRepositoryInterface $teamRepository,
        protected ImageManager $imageManager
    ) {}

    public function all(): Collection
    {
        return $this->teamRepository->all();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->teamRepository->paginate($perPage);
    }

    public function findOrFail(int $id): Team
    {
        $team = $this->teamRepository->find($id);

        if (! $team) {
            throw new ModelNotFoundException('Team not found.');
        }

        return $team;
    }

    public function store(CreateTeamData $data): Team
    {
        $logoPath = null;

        if ($data->logo instanceof UploadedFile) {
            $logoPath = $this->imageManager->upload(
                $data->logo,
                'teams'
            );
        }

        $team = $this->teamRepository->create($data, $logoPath);

        ActivityLogger::log(
            action: 'CREATED',
            entityType: 'Team',
            entityId: $team->id,
            description: "Registered new team '{$team->name}' ({$team->city}, {$team->country})."
        );

        return $team;
    }

    public function update(int $id, UpdateTeamData $data): Team
    {
        $team = $this->findOrFail($id);

        $logoPath = null;

        if ($data->logo instanceof UploadedFile) {
            $oldPath = ($team->logo && $team->logo !== 'defaults/team-crest.png')
                ? $team->logo
                : null;

            $logoPath = $this->imageManager->upload(
                $data->logo,
                'teams',
                'public',
                $oldPath
            );
        }

        $updatedTeam = $this->teamRepository->update($team, $data, $logoPath);

        ActivityLogger::log(
            action: 'UPDATED',
            entityType: 'Team',
            entityId: $updatedTeam->id,
            description: "Updated team profile for '{$updatedTeam->name}'."
        );

        return $updatedTeam;
    }

    /**
     * Accept a team and send notification mail.
     */
    public function acceptTeam(int $id): Team
    {
        $team = $this->findOrFail($id);

        $team = $this->teamRepository->updateStatus(
            $team,
            TeamStatus::ACCEPTED->value
        );

        if ($team->email) {
            \App\Jobs\SendTeamAcceptedEmailJob::dispatch($team);
        }

        ActivityLogger::log(
            action: 'ACCEPTED',
            entityType: 'Team',
            entityId: $team->id,
            description: "Accepted team application for '{$team->name}'."
        );

        return $team;
    }

    /**
     * Reject a team and send notification mail with reason.
     */
    public function rejectTeam(int $id, ?string $reason = null): Team
    {
        $team = $this->findOrFail($id);

        $team = $this->teamRepository->updateStatus(
            $team,
            TeamStatus::REJECTED->value,
            $reason
        );

        if ($team->email) {
            \App\Jobs\SendTeamRejectedEmailJob::dispatch($team, $reason);
        }

        ActivityLogger::log(
            action: 'REJECTED',
            entityType: 'Team',
            entityId: $team->id,
            description: "Rejected team '{$team->name}'." . ($reason ? " Reason: {$reason}" : '')
        );

        return $team;
    }

    /**
     * Change team status dynamically.
     */
    public function changeStatus(int $id, ChangeTeamStatusData $data): Team
    {
        if ($data->status === TeamStatus::ACCEPTED->value) {
            return $this->acceptTeam($id);
        }

        if ($data->status === TeamStatus::REJECTED->value) {
            return $this->rejectTeam($id, $data->rejection_reason);
        }

        $team = $this->findOrFail($id);
        $team = $this->teamRepository->updateStatus($team, TeamStatus::PENDING->value);

        ActivityLogger::log(
            action: 'STATUS_CHANGE',
            entityType: 'Team',
            entityId: $team->id,
            description: "Changed team '{$team->name}' status to Pending."
        );

        return $team;
    }

    public function destroy(int $id): bool
    {
        $team = $this->findOrFail($id);

        $logoPath = $team->logo;
        $teamName = $team->name;
        $teamId = $team->id;

        $deleted = $this->teamRepository->delete($team);

        if ($deleted && $logoPath && $logoPath !== 'defaults/team-crest.png') {
            $this->imageManager->delete($logoPath, 'public');
        }

        if ($deleted) {
            ActivityLogger::log(
                action: 'DELETED',
                entityType: 'Team',
                entityId: $teamId,
                description: "Deleted team '{$teamName}'."
            );
        }

        return $deleted;
    }
}
