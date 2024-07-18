<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-semibold text-2xl pb-5">EDIT CONTACTS</h3>

                    <form action="{{route('person.update', $person->id)}}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 gap-y-6">
                            <div>
                                <label class="block" for="name">Name</label>
                                <input class="block w-full border-gray-300 rounded-md" type="text" name="name" id="name" value="{{ old('name', $person->name) }}">
                                @error('name')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block" for="company">Company</label>
                                <input class="block w-full border-gray-300 rounded-md" type="text" name="company" id="company" value="{{ old('company', $person->company) }}">
                                @error('company')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block" for="email">Email</label>
                                <input class="block w-full border-gray-300 rounded-md" type="text" name="email" id="email" value="{{ old('email', $person->email) }}">
                                @error('email')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block" for="phone">Phone</label>
                                <input class="block w-full border-gray-300 rounded-md" type="text" name="phone" id="phone" value="{{ old('phone', $person->phone) }}">
                                @error('phone')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>



                        <div class="mt-6 flex items-center justify-end gap-x-6">
                            <a href="{{route('person.index')}}">Cancel</a>
                            <button class="bg-blue-600 text-white py-2 px-3 rounded-full" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
