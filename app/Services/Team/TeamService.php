<?php

namespace App\Services\Team;

use App\Data\Team\ChangeTeamStatusData;
use App\Data\Team\CreateTeamData;
use App\Data\Team\UpdateTeamData;
use App\Mail\TeamAcceptedMail;
use App\Mail\TeamRejectedMail;
use App\Models\Team;
use App\Repositories\Contracts\Team\TeamRepositoryInterface;
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

        return $this->teamRepository->create($data, $logoPath);
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

        return $this->teamRepository->update($team, $data, $logoPath);
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
            try {
                Mail::to($team->email)->send(new TeamAcceptedMail($team));
            } catch (\Exception $e) {
                Log::error('Failed to send TeamAcceptedMail: ' . $e->getMessage());
            }
        }

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
            try {
                Mail::to($team->email)->send(new TeamRejectedMail($team, $reason));
            } catch (\Exception $e) {
                Log::error('Failed to send TeamRejectedMail: ' . $e->getMessage());
            }
        }

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
        return $this->teamRepository->updateStatus($team, TeamStatus::PENDING->value);
    }

    public function destroy(int $id): bool
    {
        $team = $this->findOrFail($id);

        $logoPath = $team->logo;

        $deleted = $this->teamRepository->delete($team);

        if ($deleted && $logoPath && $logoPath !== 'defaults/team-crest.png') {
            $this->imageManager->delete($logoPath, 'public');
        }

        return $deleted;
    }
}
