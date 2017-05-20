@if (!empty($field['help']))
    @if($field['type'] == 'ckeditor')
        <p class="help-block" style="margin-top: 7px; margin-bottom: 2px;">{{ $field['help'] }}</p>
    @elseif ($field['type'] == 'bool')
        <i>({{ $field['help'] }})</i>
    @else
        <p class="help-block" style="margin-bottom: 0;">{{ $field['help'] }}</p>
    @endif
@endif
