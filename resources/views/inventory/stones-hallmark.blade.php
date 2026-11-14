@extends('layouts.app')

@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Stones & Hallmarking</h1>

    <div class="bg-white rounded p-4 shadow">
        <h2 class="font-semibold mb-3">Diamond Stone Registry</h2>

        <form class="space-y-4">
            <div>
                <label class="block text-sm font-medium mb-1">Stone Shape</label>
                <select name="shape" class="mt-1 block w-full rounded border" required>
                    <option value="round">Round Brilliant</option>
                    <option value="princess">Princess Cut</option>
                    <option value="oval">Oval</option>
                    <option value="emerald">Emerald Cut</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Carat Weight</label>
                <input type="number" name="carat_weight" step="0.01" min="0.01" required
                    class="mt-1 block w-full rounded">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Quality Grade</label>
                <input type="text" name="quality" placeholder="e.g. VS1, GIA Certified"
                    class="mt-1 block w-full rounded">
            </div>

            <button type="submit" class="btn-primary bg-green-600 text-white px-4 py-2 rounded">
                Register Stone
            </button>
        </form>

        <h3 class="font-semibold mt-5">Hallmark Records</h3>
        <p>BIS Hallmark tracking and HUID assignment.</p>
    </div>
</div>
@endsection