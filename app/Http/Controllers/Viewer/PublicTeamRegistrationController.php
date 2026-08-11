<?php

namespace App\Http\Controllers\Viewer;

use App\Data\Team\CreateTeamData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Viewer\PublicTeamRegistrationRequest;
use App\Services\Team\TeamService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PublicTeamRegistrationController extends Controller
{
    public function __construct(
        protected TeamService $teamService
    ) {}

    /**
     * Show the public team registration form.
     */
    public function show(): View
    {
        return view('frontend.team-registration');
    }

    /**
     * Store public team registration request.
     */
    public function store(PublicTeamRegistrationRequest $request): RedirectResponse
    {
        $teamData = CreateTeamData::from($request);

        $this->teamService->store($teamData);

        return redirect()->back()
            ->with('success', 'Your team registration form has been submitted successfully! The admin team will review your application.');
    }
}
