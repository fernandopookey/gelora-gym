<div class="col-xl-12">
    <div class="page-title flex-wrap justify-content-end">
        <a href="{{ route('cetak-staff-pdf') }}" target="_blank" class="btn btn-info">Cetak PDF</a>
    </div>
</div>

<div class="tab-content" id="myTabContent-1">
    <div class="tab-pane fade show active" id="#" role="tabpanel" aria-labelledby="home-tab">
        <div class="card-body pt-0">
            <!-- Nav tabs -->
            <div class="custom-tab-1">
                <ul class="nav nav-tabs">
                    {{-- <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#classInstructor">
                            Class Instructor
                        </a>
                    </li> --}}
                    <li class="nav-item active">
                        <a class="nav-link show active" data-bs-toggle="tab" href="#customerService">
                            Customer Service
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#csPos">
                            Customer Service POS
                        </a>
                    </li> --}}
                    {{-- <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#fitnessConsultant">
                            Fitness Consultant
                        </a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#personalTrainer">
                            Personal Trainer
                        </a>
                    </li>
                    @if (Auth::user()->role == 'ADMIN')
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#administrator">
                                Adminstrator
                            </a>
                        </li>
                    @endif
                    {{-- <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#physiotherapy">
                            Physiotherapy
                        </a>
                    </li> --}}
                    {{-- <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#ptLeader">
                            PT Leader
                        </a>
                    </li> --}}
                </ul>
                <div class="tab-content">
                    @include('admin.staff.administrator.index')
                    @include('admin.staff.class-instructor.index')
                    @include('admin.staff.customer-service.index')
                    @include('admin.staff.customer-service-pos.index')
                    @include('admin.staff.fitness-consultant.index')
                    @include('admin.staff.personal-trainer.index')
                    @include('admin.staff.physiotherapy.index')
                    @include('admin.staff.pt-leader.index')
                </div>
            </div>
        </div>
    </div>
</div>
