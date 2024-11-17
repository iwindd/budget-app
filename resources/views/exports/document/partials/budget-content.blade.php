<section>
    <table>
        <tr>
            <td class="fit indent">{{ __('exports.document-order_id') }}</td>
            <td class="under"><span>{{ $order }}</span></td>
            <td class="fit">{{ __('exports.document-order_at') }}</td>
            <td class="under"><span>{{ $format->date($order_at) }}</span></td>
            <td class="fit">{{ __('exports.document-allowed') }}</td>
        </tr>
    </table>
    <table>
        <tr>
            <td class="fit">{{ __('exports.document-name-2') }}</td>
            <td class="under"><span>{{ $name }}</span></td>
            <td class="fit">{{ __('exports.document-position') }}</td>
            <td class="under"><span>{{ $position }}</span></td>
        </tr>
    </table>
    <table>
        <tr>
            <td class="fit">{{ __('exports.document-affiliation') }}</td>
            <td class="under"><span>{{ $affiliation }}</span></td>
            <td class="fit">{{ __('exports.document-companions') }}</td>
            <td class="under"><span>{{ $companions[0]->user->name ?? '-' }}
                    {{ $companions->count() > 1 ? ',' : '' }}</span></td>
        </tr>
    </table>
    @if ($companions->count() > 1)
        @foreach ($companions->slice(1)->chunk(3) as $companionChunk)
            <table>
                <tr>
                    <td class="under text-left">
                        <span>
                            {{ $companionChunk->pluck('user.name')->implode(', ') }}
                        </span>
                    </td>
                </tr>
            </table>
        @endforeach
    @endif
    <p>
        {{ __('exports.document-subject') }}
        <span style="padding: 0 0.5em;">
            {{ $header }} / {{ $subject }}
        </span>
        {{ __('exports.document-subject-suffix') }}
    </p>
</section>
