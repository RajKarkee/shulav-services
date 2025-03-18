@if ($vendor->opening != null)

    <div class="bg-white shadow mt-2">
        <div class="card-body">
            <div class="title">
                Opening Hours
            </div>
            <div class="desc">
                <table class="w-100">
                    @foreach (\App\Extra\Opening::options as $code => $name)
                        @php
                            $opening = (object) $vendor->opening[$code];
                        @endphp
                        <tr class="opening-hour {{ $opening->isopen ? 'open' : 'close' }}">
                            <td>
                                {{ $name }}
                            </td>
                            <td class="text-end">
                                @if ($opening->isopen)
                                    {{ $opening->start }} - {{ $opening->end }}
                                @else
                                    <span class="text-danger">Closed</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endif
