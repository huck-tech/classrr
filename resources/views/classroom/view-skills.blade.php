<div class="row">
    <div class="col-md-3">
        <h3>Skills<br />
		<small>You'll earn these skills</small></h3>
		
    </div>
    <div class="col-md-9">        
        @forelse($skills->slice(0, 9) as $skill)
            <span class="label label-info">{{ $skill->pivot->amount_point }}+ {{ $skill->name }}</span>
        @empty
        <div class="alert alert-info">This class has no skill attached to it</div>
        @endforelse
        
        @if($skills->count() > 9)            
            <span id="collapse-skill" class="collapse">
            @foreach($skills->splice(9) as $skill)
                <span class="label label-info">{{ $skill->pivot->amount_point }}+ {{ $skill->name }}</span> 
            @endforeach
            </span>
            <div><a class="btn btn-xs" data-toggle="collapse" data-target="#collapse-skill" id="btn-more-skill">more +</a></div>
        @endif        
    </div>
</div>