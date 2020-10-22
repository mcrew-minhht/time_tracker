<div class="box-numpaging float-right overflow-hidden">
    {!! Form::select('numpaging', App\Libs\Constants::$list_numpaging, Request::get("numpaging"),array('class' => 'form-control', 'id' => 'selectNumpaging')) !!}
    <span>{{__('record in 1 page')}}</span>
</div>
<script type="text/javascript">

    $(document).ready(function () {
        var pagingCurrent = '{{Request::get("numpaging")}}';
        $("#selectNumpaging").change(function () {
            var newUrl = common.replaceUrlParam(location.href, 'numpaging', $(this).val());
            window.location.href = newUrl;
        });
    });
</script>
