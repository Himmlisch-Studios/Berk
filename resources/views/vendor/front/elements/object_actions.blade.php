@php $helper = $front->getActionsHelper($object, $base_url, $edit_link ?? null, $show_link ?? null); @endphp
<td class="whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
    @if( $helper->isSortable() )
        <!-- Sortable buttons -->
        {!! getButtonByName('up')->addLink($helper->upUrl())->setType('')->setTitle('')->setClass('inline-block text-blue-400 hover:text-blue-600')->form() !!}
        {!! getButtonByName('down')->addLink($helper->downUrl())->setType('')->setTitle('')->setClass('inline-block text-blue-400 hover:text-blue-600')->form() !!}
    @endif
    @if( $helper->canShow() )
        <!-- Edit button -->
        {!! getButtonByName('show')->addLink($helper->showUrl())->setType('')->setTitle('')->setClass('inline-block text-blue-400 hover:text-blue-600')->form() !!}
    @endif
    @if( $helper->canUpdate() )
        <!-- Edit button -->
        {!! getButtonByName('edit')->addLink($helper->updateUrl())->setType('')->setTitle('')->setClass('inline-block text-blue-400 hover:text-blue-600')->form() !!}
    @endif
    @if( $helper->canRemove() )
        <!-- Remove button -->
        {!! getButtonByName('delete', $front, $object)->setType('')->setTitle('')->setClass('inline-block text-red-400 hover:text-red-600')->form() !!}
    @endif
    @foreach($helper->getActions($object) as $action)
        <a href="{{ $action->url }}" class="inline-block text-blue-400 hover:text-blue-600" aria-hidden="true" title="{{ $action->title }}">
            <i class="{{$action->icon}}"></i>
        </a>
    @endforeach
</td>
