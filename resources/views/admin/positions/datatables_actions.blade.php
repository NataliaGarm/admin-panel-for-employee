<a href="{{ route('positions.show', $position) }}" class="edit btn btn-default btn-xs" title="Details"><i class="fa fa-lg fa-fw fa-eye"></i></a>

<a href="{{ route('positions.edit', $position) }}" class="edit btn btn-default btn-xs" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>
<a href="#deletePositionForm" data-toggle="modal" data-target="#deletePositionForm{{ $position->id }}" class="edit btn btn-default btn-xs" title="Delete"><i class="fas fa-trash"></i></a>


{{-- Themed --}}
<x-adminlte-modal id="deletePositionForm{{ $position->id }}" title="Remove position" theme="minimal"
                  size='lg' disable-animations>
    <form action="{{ route('positions.destroy', $position) }}" method="POST">
        @csrf
        @method('DELETE')
        <p>Are you sure you want to remove {{ $position->name }} position?</p>
        <x-adminlte-button class="btn-flat" type="submit" id="submit" label="Remove" theme="secondary" />
    </form>

</x-adminlte-modal>