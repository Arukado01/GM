<div class="row mb-5">
    <div class="col-md-12 text-center project-header">
        <h1 class="project-title">{{ $project->name }}</h1>
        {{ $project->location }} <br>
        <strong>Ing. Supervisor:</strong> {{ $project->ingSupervisorName() }}
    </div>
</div>