@props(['company'])

<div class="flex flex-wrap space-y-4 lg:space-y-0">
    <div class="w-full md:w-1/3 px-0 md:px-2">
        <div class="flex w-full flex-col gap-4 p-4 rounded-xl bg-white h-full">
            <label class="relative font-bold">
                Name
                <input class="block font-normal w-full text-gray-500 italic" type="text" value="{{$company->name}}" disabled/>
            </label>
            <label class="relative font-bold">
                Email
                <input class="block font-normal w-full text-gray-500 italic" type="text" value="{{$company->email}}" disabled/>
            </label>
            <label class="relative font-bold">
                Phone
                <input class="block font-normal w-full text-gray-500 italic" type="text" value="{{$company->phone}}" disabled/>
            </label>
        </div>
    </div>
</div>
