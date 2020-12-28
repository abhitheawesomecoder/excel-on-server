<div id="entity-comments-container">

</div>

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            BAP_Platform.commentsExtension('{{ $entity->id }}','{{ json_encode(get_class($entity)) }}' );
        });
    </script>

@endpush