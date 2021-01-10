<div class="row align-items-center">
    <div class="col-6 d-flex justify-content-center">
        <div class="d-flex flex-column pt-3 text-center">
            <span><strong>{{Str::ucfirst($pokemon->getNome())}}</strong></span>
            <img src="{{$pokemon->getSpriteDefault()}}" width="150" class="img-fluid" alt="{{$pokemon->getNome()}}">
        </div>
    </div>
    <div class="col-6">
       <ul style="list-style: none" class="pl-0">
         @foreach ($pokemon->getStats() as $stat)
             <li>
             <div class="d-flex justify-content-between">
                 {{$stat->stat->name}}
                 <span class="pr-3">{{ $stat->base_stat }}</span>
             </div>
             </li>
         @endforeach
       </ul>
    </div>
 </div>