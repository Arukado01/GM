<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="sl_projects">Seleccionar Proyecto</label>
            <select name="sl_projects" id="sl_projects" class="form-control mr-sm-2">
                <option value="">Seleccionar</option>
                @foreach($projects as $prj)
                    <option data-url="{{ route('home.project', ['project_id' => $prj->hashid]) }}"
                            value="{{ $prj->hashid }}" {{ $prj->hashid == $project->hashid ? 'selected' : ''}}>
                        {{ $prj->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <hr>
    </div>
</div>