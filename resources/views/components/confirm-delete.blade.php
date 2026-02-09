@props([
    'action',
    'method' => 'DELETE',
    'title' => 'Tem certeza?',
    'text' => 'Esta ação não pode ser desfeita!',
    'confirmText' => 'Sim, deletar!',
    'cancelText' => 'Cancelar',
    'id' => 'delete-form-' . uniqid(),
])

<form id="{{ $id }}" action="{{ $action }}" method="POST" style="display: inline;">
    @csrf
    @method($method)

    <button type="button" {{ $attributes->merge(['class' => 'btn', 'style' => 'display: inline-flex !important; align-items: center; gap: 0.25rem;']) }} data-form-id="{{ $id }}"
        data-title="{{ $title }}" data-text="{{ $text }}" data-confirm-text="{{ $confirmText }}"
        data-cancel-text="{{ $cancelText }}" onclick="confirmDelete(this)">
        {{ $slot }}
    </button>
</form>

@once
    @push('scripts')
        <script>
            function confirmDelete(button) {
                const formId = button.getAttribute('data-form-id');
                const title = button.getAttribute('data-title');
                const text = button.getAttribute('data-text');
                const confirmText = button.getAttribute('data-confirm-text');
                const cancelText = button.getAttribute('data-cancel-text');

                Swal.fire({
                    title: title,
                    text: text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: confirmText,
                    cancelButtonText: cancelText,
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(formId).submit();
                    }
                });
            }
        </script>
    @endpush
@endonce
