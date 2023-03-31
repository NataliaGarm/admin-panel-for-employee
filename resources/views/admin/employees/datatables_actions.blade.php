<a href="{{ route('employees.show', $employee) }}" class="edit btn btn-default btn-xs" title="Details"><i class="fa fa-lg fa-fw fa-eye"></i></a>

<a href="{{ route('employees.edit', $employee) }}" class="edit btn btn-default btn-xs" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>
<a href="#deleteEmployeeForm" data-toggle="modal" data-target="#deleteEmployeeForm{{ $employee->id }}" class="edit btn btn-default btn-xs" title="Delete"><i class="fas fa-trash"></i></a>


{{-- Themed --}}
<x-adminlte-modal id="deleteEmployeeForm{{ $employee->id }}" title="Remove employee" theme="minimal"
                  size='lg' disable-animations>
    <form action="{{ route('employees.destroy', $employee) }}" method="POST">
        @csrf
        @method('DELETE')
        <p>Are you sure you want to remove {{ $employee->name }} ?</p>
        <x-adminlte-button class="btn-flat" type="submit" id="submit" label="Remove" theme="secondary" />
    </form>
</x-adminlte-modal>