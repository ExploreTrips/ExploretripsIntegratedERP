<div class="card sticky-top" style="top:30px">
    <div class="list-group list-group-flush" id="useradd-sidenav">
        <a href="{{ route('branch.index') }}"
            class="list-group-item list-group-item-action border-0 {{ Request::routeIs('branch*') ? 'active' : '' }}">
            <i class="ti ti-building me-2"></i>
            {{ __('Branch') }}
            <div class="float-end">
                <i class="ti ti-chevron-right"></i>
            </div>
        </a>


        {{-- <a href="#" class="list-group-item list-group-item-action border-0 {{ (request()->is('department*') ? 'active' : '')}}">{{__('Department')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="#" class="list-group-item list-group-item-action border-0 {{ (request()->is('designation*') ? 'active' : '')}}">{{__('Designation')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="#" class="list-group-item list-group-item-action border-0 {{ (Request::route()->getName() == 'leavetype.index' ? 'active' : '')}}">{{__('Leave Type')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a> --}}

        <a href="{{ route('document.index') }}"
            class="list-group-item list-group-item-action border-0 {{ Request::routeIs('document.index') ? 'active' : '' }}">
            <i class="ti ti-file-text me-2"></i>
            {{ __('Document Type') }}
            <div class="float-end">
                <i class="ti ti-chevron-right"></i>
            </div>
        </a>



        {{-- <a href="#" class="list-group-item list-group-item-action border-0 {{ (request()->is('paysliptype*') ? 'active' : '')}}">{{__('Payslip Type')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="#" class="list-group-item list-group-item-action border-0 {{ (request()->is('allowanceoption*') ? 'active' : '')}}">{{__('Allowance Option')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="#" class="list-group-item list-group-item-action border-0 {{ (request()->is('loanoption*') ? 'active' : '')}}">{{__('Loan Option')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="#" class="list-group-item list-group-item-action border-0 {{ (request()->is('deductionoption*') ? 'active' : '')}}">{{__('Deduction Option')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="#" class="list-group-item list-group-item-action border-0 {{ (request()->is('goaltype*') ? 'active' : '')}}">{{__('Goal Type')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="#" class="list-group-item list-group-item-action border-0 {{ (request()->is('trainingtype*') ? 'active' : '')}}">{{__('Training Type')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="#" class="list-group-item list-group-item-action border-0 {{ (request()->is('awardtype*') ? 'active' : '')}}">{{__('Award Type')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="#" class="list-group-item list-group-item-action border-0 {{ (request()->is('terminationtype*') ? 'active' : '')}}">{{__('Termination Type')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="#" class="list-group-item list-group-item-action border-0 {{ (request()->is('job-category*') ? 'active' : '')}}">{{__('Job Category')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="#" class="list-group-item list-group-item-action border-0 {{ (request()->is('job-stage*') ? 'active' : '')}}">{{__('Job Stage')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        @can('manage performance type')
        <a href="#" class="list-group-item list-group-item-action border-0 {{ request()->is('performanceType*') ? 'active' : '' }}">{{__('Performance Type')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
        @endcan

        <a href="#" class="list-group-item list-group-item-action border-0 {{ request()->is('competencies*') ? 'active' : '' }}">{{__('Competencies')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a> --}}

    </div>
</div>
