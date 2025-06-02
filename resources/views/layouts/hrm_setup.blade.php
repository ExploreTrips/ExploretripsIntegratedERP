<div class="card sticky-top" style="top:30px">
    <div class="list-group list-group-flush" id="useradd-sidenav">
     <a href="{{ route('branch.index') }}"
   class="flex flex-row sm:flex-col sm:items-start items-center justify-between sm:justify-center px-4 py-2 border-b sm:border-none hover:bg-gray-100 transition duration-150 ease-in-out w-full {{ Request::routeIs('branch*') ? 'bg-gray-200 font-semibold text-primary' : '' }}">

    <div class="flex flex-row items-center space-x-2">
        <i class="ti ti-building text-lg"></i>
        <span class="text-sm sm:text-base">{{ __('Branch') }}</span>
    </div>

    <i class="ti ti-chevron-right text-sm sm:text-base sm:mt-2 sm:self-end"></i>
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
        <a href="{{ route('paysliptype.index') }}"
            class="list-group-item list-group-item-action border-0 {{ Request::routeIs('paysliptype*') ? 'active' : '' }}">
            {{-- <i class="ti ti-file-dollar me-2"></i> --}}
            <i class="ti ti-file-text me-2"></i>

            {{ __('Payslip Type') }}
            <div class="float-end">
                <i class="ti ti-chevron-right"></i>
            </div>
        </a>
        <a href="{{ route('allowanceoption.index') }}" class="list-group-item list-group-item-action border-0 {{ request()->is('allowanceoption*') ? 'active' : '' }}">
            <i class="ti ti-cash me-2"></i> {{ __('Allowance Option') }}
            <div class="float-end"><i class="ti ti-chevron-right"></i></div>
        </a>


    {{-- <a href="#" class="list-group-item list-group-item-action border-0 {{ (request()->is('loanoption*') ? 'active' : '')}}">{{__('Loan Option')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

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
