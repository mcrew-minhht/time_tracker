<style>
    #div1, #div2 {
        float: left;
        width: 100%;
        min-height: 500px;
        height: 100%;
        margin: 10px;
        padding: 10px;
        border-left: 2px solid #dee2e6;
        border-top: 2px solid #dee2e6;
        border-bottom: 2px solid #dee2e6;
        overflow-y:scroll
    }
</style>
<div class="container-fluid group-employee-project bg-white shadow">
    <div class="row">
        <div class="col-xs-6 col-md-6 col-lg-6">
            <div class="panel panel-default">
                <div id="div1" ondrop="drop(event)" ondragover="allowDrop(event)">
                    @foreach($list_employees as $key => $employee)
                    <p draggable="true" ondragstart="drag(event)" data-id="{{$employee->id}}" id="<?= $key ?>">{{$employee->name}}</p>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-md-6 col-lg-6">
            <div class="panel panel-default">
                <div id="div2" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
            </div>
        </div>
    </div>
</div>
