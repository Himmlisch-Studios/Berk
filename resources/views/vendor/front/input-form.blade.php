<div class="col-span-{{ $input->bootstrap_width() }}">
    <label class="block text-sm font-medium text-gray-700">{{ $input->title }}</label>

    <div class="flex">
        {!! $input->form() !!}
    </div>

    @if (isset($input->help))
        <small class="block mt-2 text-xs text-gray-400">
            {!! $input->help !!}
        </small>
    @endif
</div>
