@foreach($positions as $position)
    @if($vote->contains('position_id',$position->id))
        <div class="card rounded-0">
            <div class="card-header">
                <strong>{{ $position->name }}</strong>
            </div>
            <div class="card-body pt-2">
                @foreach($position->candidates as $candidate)
                    @if($position->relation_level == 0 || $candidate->voter->grade_level == auth()->user()->grade_level)
                        <div class="d-flex px-3 m-1 mt-3 align-items-center">
                            <div class="d-flex flex-row align-items-center">
                                    <div class="img-voter mr-4">
                                        <img class="img-fluid rounded-circle" src="{{ $candidate->profile_url }}" />
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h4>{{ $candidate->voter->name }}</h4>
                                    </div>
                            </div>
                            @if($position->max_vote > 1)
                                @if($vote->contains('candidate_id',$candidate->id))
                                    <div class="icheck-primary d-inline ml-auto">
                                        <input type="checkbox" name="position_{{ $position->id }}[]" checked disabled id="candidate_{{ $candidate->id }}">
                                        <label for="candidate_{{ $candidate->id }}">
                                        </label>
                                    </div>
                                @else
                                    <div class="icheck-primary d-inline ml-auto">
                                        <input type="checkbox" name="position_{{ $position->id }}[]" disabled id="candidate_{{ $candidate->id }}">
                                        <label for="candidate_{{ $candidate->id }}">
                                        </label>
                                    </div>
                                @endif
                            @else
                                @if($vote->contains('candidate_id',$candidate->id))
                                    <div class="icheck-primary d-inline ml-auto">
                                        <input type="radio" name="position_{{ $position->id }}" value="{{ $candidate->id }}" checked disabled id="candidate_{{ $candidate->id }}">
                                        <label for="candidate_{{ $candidate->id }}">
                                        </label>
                                    </div>
                                @else
                                    <div class="icheck-primary d-inline ml-auto">
                                        <input type="radio" name="position_{{ $position->id }}" value="{{ $candidate->id }}" disabled id="candidate_{{ $candidate->id }}">
                                        <label for="candidate_{{ $candidate->id }}">
                                        </label>
                                    </div>
                                @endif
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @endif
@endforeach