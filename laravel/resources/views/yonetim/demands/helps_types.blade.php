@foreach($helpTypes as $ht)
    <div class="col-md-2">
        <div class="form-group">
            <label for="exampleInputEmail1">{{ $ht->name  }}</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-hand-paper"></i></span>
                </div>
                <input id="{{$ht->slug}}" type="number" min="1" class="form-control" name="{{$ht->slug}}"
                       tabindex="0"
                       placeholder="{{$ht->metrik}}"

                @foreach($helpIdList as $hi)
                    @php($help = Helpers::getShowHelp($hi))
                           @if ($help!= null and $help->type->slug == $ht->slug)
                               @if (is_null(old($ht->slug)))
                                    value="{{ $help->quantity }}"
                               @else
                                    value="{{ old($ht->slug) }}"
                               @endif
                           @endif
                @endforeach

                @if (in_array($ht->slug,$slug_list) == false)
                       @if (is_null(old($ht->slug)))
                            value=""
                       @else
                            value="{{ old($ht->slug) }}"
                       @endif
                @endif
                >
            </div>
        </div>
    </div>
@endforeach

<div class="col-md-12">
    <hr class="alert-info" style="width: 100%">
</div>
