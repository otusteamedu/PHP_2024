@forelse ($youtubechannels ?? '' as $youtubechannel)
    @include('youtubechannels.blocks.list.item')
@empty
    <p>Каналы не найдены</p>
@endforelse
