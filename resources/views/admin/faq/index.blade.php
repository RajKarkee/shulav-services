@extends('admin.layout.app')
@section('css')
<link href="{{asset('admin/plugins/DataTables/datatables.min.css')}}" rel="stylesheet">   

@endsection
@section('page-option')
<a class="btn btn-primary" href="{{route('admin.faq.add')}}">
   Add New faq
</a>
@endsection
@section('s-title')
    <li class="breadcrumb-item">
        Faqs
    </li>
    
    
    
@endsection
@section('content')

<div class="card shadow">
    <div class="card-body">
        <table id="datatable" class="table">
            <thead>
                <tr>
                    <th>REF ID</th>
                    <th>
                        question
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($faqs as $faq)
                    <tr>
                        <td>
                            {{$faq->id}}
                        </td>
                        <td>
                            {{$faq->q}}
                        </td>
                        <td>
                            <a href="{{route('admin.faq.edit',['faq'=>$faq->id])}}" class="btn btn-sm btn-secondary">
                                Edit
                            </a>
                            <a href="{{route('admin.faq.del',['faq'=>$faq->id])}}" onclick="return prompt('Enter yes To Delete Faq')=='yes';" class="btn btn-sm btn-danger">
                                del
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


@endsection
@section('script')
<script src="{{asset('admin/plugins/DataTables/datatables.min.js')}}"></script>
<script>
    var table;
    $(function () {
        table=$('#datatable').DataTable({
            "columnDefs": [
                { "sortable":false,"searchable": false, "targets": 2 }
            ]
        });
    });
</script>
@endsection
