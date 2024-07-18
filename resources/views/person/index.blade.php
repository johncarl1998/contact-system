<x-app-layout>

    <div class="py-12">
@if(session('success'))
        <div id="success-message">{{ session('success') }}</div>
        <script>
            // Reload the page after a short delay to allow the user to see the message
            setTimeout(function() {
                window.location.reload();
            }, 2000); // Adjust the delay time as needed (2000 milliseconds = 2 seconds)
        </script>
    @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-end mb-4">
                        <a class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-3 rounded-md mr-3" href="{{ route('person.create') }}">Add Contact</a>

                    </div>

                    <input class="mb-4" id="search" placeholder="Search..." class="mb-4 block w-full px-4 py-1.5 border border-gray-300 rounded-md">

                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Company</th>
                                <th class="px-6 py-3 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                                <th class="px-6 py-3 bg-gray-200 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="results">
                            @foreach ($people as $person)
                                <tr>
                                    <td class="border px-6 py-4">{{ $person->name ?? '' }}</td>
                                    <td class="border px-6 py-4">{{ $person->company ?? '' }}</td>
                                    <td class="border px-6 py-4">{{ $person->email ?? '' }}</td>
                                    <td class="border px-6 py-4">{{ $person->phone ?? '' }}</td>
                                    <td class="border px-6 py-4">
                                        <a href="{{ route('person.edit', $person->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                        <form action="{{ route('person.destroy', $person->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure you want to delete?')" class="text-red-600 hover:underline ml-2">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination links -->
                    <div class="mt-4">
                        {{ $people->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#search').on('keyup', function() {
                let query = $(this).val();
                $.ajax({
                    url: "{{ route('search') }}",
                    type: "GET",
                    data: {'query': query},
                    success: function(data) {
                        $('#results').html(data);
                    }
                });
            });
        });
    </script>
</x-app-layout>