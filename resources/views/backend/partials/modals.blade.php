<!-- Quick Action Modals -->

<!-- MODAL 1: ADD COMPETITION -->
<div class="modal fade" id="modalAddCompetition" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold text-white"><i class="fas fa-trophy mr-2"></i>Create New Competition</h5>
                <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form onsubmit="event.preventDefault(); showHandballToast('Success', 'Competition created successfully!'); $('#modalAddCompetition').modal('hide');">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Competition Title</label>
                        <input class="form-control" type="text" placeholder="e.g. National Handball Cup 2026" required>
                    </div>
                    <div class="form-row mb-3">
                        <div class="col-6">
                            <label class="font-weight-bold">Type</label>
                            <select class="form-control">
                                <option>League</option>
                                <option>Knockout Tournament</option>
                                <option>Group + Knockout</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="font-weight-bold">Season</label>
                            <input class="form-control" type="text" value="2025/2026">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Max Participating Teams</label>
                        <input class="form-control" type="number" value="16" min="2" max="64">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary btn-sm" type="submit">Create Competition</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL 2: REGISTER TEAM -->
<div class="modal fade" id="modalRegisterTeam" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title font-weight-bold text-white"><i class="fas fa-shield-alt mr-2"></i>Register Handball Team</h5>
                <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form onsubmit="event.preventDefault(); showHandballToast('Success', 'Team registered successfully!'); $('#modalRegisterTeam').modal('hide');">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Team Full Name</label>
                        <input class="form-control" type="text" placeholder="e.g. Al Ahly Handball Club" required>
                    </div>
                    <div class="form-row mb-3">
                        <div class="col-6">
                            <label class="font-weight-bold">Short Name</label>
                            <input class="form-control" type="text" placeholder="AHL" maxlength="4" required>
                        </div>
                        <div class="col-6">
                            <label class="font-weight-bold">City</label>
                            <input class="form-control" type="text" placeholder="Cairo" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Country</label>
                        <input class="form-control" type="text" placeholder="Egypt" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-success btn-sm" type="submit">Register Team</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL 3: SCHEDULE MATCH -->
<div class="modal fade" id="modalScheduleMatch" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title font-weight-bold text-white"><i class="fas fa-calendar-plus mr-2"></i>Schedule Match Fixture</h5>
                <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form onsubmit="event.preventDefault(); showHandballToast('Match Scheduled', 'New match fixture created!'); $('#modalScheduleMatch').modal('hide');">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Select Competition</label>
                        <select class="form-control">
                            <option>Egyptian Premier League 2025/2026</option>
                            <option>EHF Champions League 2025/2026</option>
                            <option>IHF World Handball Championship</option>
                        </select>
                    </div>
                    <div class="form-row mb-3">
                        <div class="col-6">
                            <label class="font-weight-bold">Home Team</label>
                            <select class="form-control">
                                <option>Al Ahly SC</option>
                                <option>FC Barcelona</option>
                                <option>THW Kiel</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="font-weight-bold">Away Team</label>
                            <select class="form-control">
                                <option>Zamalek SC</option>
                                <option>PSG Handball</option>
                                <option>Veszprém HC</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-6">
                            <label class="font-weight-bold">Date & Time</label>
                            <input class="form-control" type="datetime-local" required>
                        </div>
                        <div class="col-6">
                            <label class="font-weight-bold">Round Number</label>
                            <input class="form-control" type="number" value="1" min="1">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-info btn-sm text-white" type="submit">Schedule Fixture</button>
                </div>
            </form>
        </div>
    </div>
</div>
