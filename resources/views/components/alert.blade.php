@props(['type' => 'success', 'message', 'toast' => true])

@if(isset($message))
<script>
    @if($toast)
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        
        Toast.fire({
            icon: '{{ $type }}',
            title: '{{ $message }}'
        });
    @else
        Swal.fire({
            icon: '{{ $type }}',
            title: '{{ $type === "error" ? "Erro!" : ($type === "success" ? "Sucesso!" : "Atenção!") }}',
            text: '{{ $message }}',
            confirmButtonText: 'OK'
        });
    @endif
</script>
@endif
