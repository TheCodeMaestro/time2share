<x-app-layout>
    <section class="blocked-message">
        <h2>You have been blocked</h2>
        <p>This means that you can no longer access Time2share.
            If you have any questions or if you think this was a mistake, please contact support</p>
        <form action="{{ route('logout')}}" method="POST">
            @csrf
            <button type="submit" class="primary-button" style="margin-top: 0.5rem;">Ok</button>
        </form>
    </section>
</x-app-layout>