@extends('layouts.admin')

@section('page-title')
    {{__('Manage Payslip Type')}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Payslip Type')}}</li>
@endsection

@section('action-btn')
    <div class="float-end">
        @can('create payslip type')
            <a href="#" data-url="{{ route('paysliptype.create') }}" data-ajax-popup="true" data-title="{{__('Create New Payslip Type')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary p-2">
                <i class="ti ti-plus"></i>
                {{__('Create New Payslip Type')}}
            </a>

        @endcan
    </div>
@endsection



@section('content')

    <div class="row">
        <div class="col-3">
            @include('layouts.hrm_setup')
        </div>
        <div class="col-9">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th>{{__('Payslip Type')}}</th>
                                <th width="200px">{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            @foreach ($paysliptypes as $paysliptype)
                                <tr>
                                    <td>{{ $paysliptype->name }}</td>

                                    <td>


                                        @can('edit payslip type')
                                            <div class="action-btn me-2">
                                                <a href="#" class="mx-3 btn btn-sm align-items-center bg-info" data-url="{{ URL::to('paysliptype/'.$paysliptype->id.'/edit') }}" data-ajax-popup="true" data-title="{{__('Edit Payslip Type')}}" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                    <i class="ti ti-pencil text-white"></i>
                                                </a>
                                            </div>
                                        @endcan

                                        @can('delete payslip type')
                                            <div class="action-btn">
                                                <form method="POST" action="{{ route('paysliptype.destroy', $paysliptype->id) }}" id="delete-form-{{ $paysliptype->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="mx-3 btn btn-sm align-items-center bs-pass-para bg-danger" data-bs-toggle="tooltip" title="{{ __('Delete') }}">
                                                        <i class="ti ti-trash text-white"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            @endcan
                                        </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
