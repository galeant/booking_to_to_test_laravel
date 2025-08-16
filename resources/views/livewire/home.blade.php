

<div class="container-fluid mt-5">

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
        <button class="nav-link" id="nationality-tab" data-bs-toggle="tab" data-bs-target="#nationality" type="button" role="tab" aria-controls="nationality" aria-selected="true">
            Nationality
        </button>
        </li>
        <li class="nav-item" role="presentation">
        <button class="nav-link active" id="user-tab" data-bs-toggle="tab" data-bs-target="#user" type="button" role="tab" aria-controls="user" aria-selected="false">
            User
        </button>
        </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content border border-top-0 p-3" id="myTabContent">
        <!-- Nationality Tab -->
        <div class="tab-pane fade" id="nationality" role="tabpanel" aria-labelledby="nationality-tab">
            <div class="d-flex justify-content-between mb-1">
                <h5>Nationality</h5>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nationality Name</th>
                                <th>Nationality Code</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ( $nationalities as $national )
                        <tr>
                                <td>{{$national['id']}}</td>
                                <td>{{$national['name']}}</td>
                                <td>{{$national['code']}}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-warning" wire:click="naEdit({{$national['id']}})">Edit</button>
                                        <button type="button" class="btn btn-danger" wire:click="naDelete({{$national['id']}})">Delete</button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">No Data</td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Nationality Name</label>
                        <input type="text" class="form-control" wire:model.defer="nName">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Nationality Code</label>
                        <input type="text" class="form-control" wire:model.defer="nCode">
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-danger" wire:click="resetNa">Reset</button>
                        <button class="btn btn-success" wire:click="naSave">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Tab -->
        <div class="tab-pane fade  show active" id="user" role="tabpanel" aria-labelledby="user-tab">
            <div class="d-flex justify-content-between mb-1">
                <h5>User</h5>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nationality</th>
                                <th>Name</th>
                                <th>Birth Of Date</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ( $users as $ui => $user )
                                <tr>
                                    <td>{{$user['cst_id']}}</td>
                                    <td>{{$user['nationality']}}</td>
                                    <td>{{$user['name']}}</td>
                                    <td>{{$user['dob']}}</td>
                                    <td>{{$user['phone']}}</td>
                                    <td>{{$user['email']}}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-warning" wire:click="userEdit({{$user['cst_id']}})">Edit</button>
                                            <button type="button" class="btn btn-danger" wire:click="userDelete({{$user['cst_id']}})">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                            <tr>
                                <td colspan="4">No Data</td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">User Name</label>
                                <input type="text" class="form-control" wire:model.defer="uName">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">User Birth Date</label>
                                <input type="date" class="form-control" wire:model.defer="uDob">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-control" wire:model.defer="uEmail">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-control" wire:model.defer="uPhone">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nationality</label>
                                <select class="form-control" wire:model.defer="uNationality">
                                    <option value="">--Select Nationality--</option>
                                    @foreach($nationalities as $n)
                                        <option value="{{$n['id']}}">{{$n['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 mt-2">
                                <button class="btn btn-danger" wire:click="uReset">Reset</button>
                                <button class="btn btn-success" wire:click="userSave">Save</button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        @foreach($families as $if => $iFam)
                            <div class="col-md-6 mt-1">
                                <div class="card card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label">Family Name</label>
                                                <input type="text" class="form-control" wire:model.defer="families.{{$if}}.fName">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label">Family Birth of Date</label>
                                                <input type="date" class="form-control" wire:model.defer="families.{{$if}}.fDob">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label">Family Relation</label>
                                                <select class="form-control" wire:model.defer="families.{{$if}}.fRelation">
                                                    <option value="">--Select Relation--</option>
                                                    @foreach($relations as $ir => $r)
                                                        <option value="{{$r}}">{{$ir}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            @if($if == 0)
                                                <button class="btn btn-success" wire:click="addFamily">Add New</button>
                                            @else
                                                <button type="button" class="btn btn-danger" wire:click="deleteFamily({{$if}})">Delete</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
