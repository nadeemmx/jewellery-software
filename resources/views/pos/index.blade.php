@extends('layouts.app')

@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Jewellery POS</h1>

    <div class="bg-white rounded p-4 mb-4 shadow max-w-2xl">
        <h2 class="font-semibold mb-4">Calculate Price</h2>

        <form id="priceForm" class="space-y-4">
            <div>
                <label class="block text-sm font-medium mb-1">Metal Type</label>
                <select name="metal_type" class="mt-1 block w-full rounded border" required>
                    <option value="Gold">Gold</option>
                    <option value="Silver">Silver</option>
                    <option value="Platinum">Platinum</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Purity</label>
                <select name="purity" class="mt-1 block w-full rounded border" required>
                    <option value="24K">24K</option>
                    <option value="22K">22K</option>
                    <option value="18K">18K</option>
                    <option value="14K">14K</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Gross Weight (grams)</label>
                <input type="number" name="gross_weight" step="0.01" min="0" required
                    class="mt-1 block w-full rounded border">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Stone Weight (carats)</label>
                <input type="number" name="stone_weight" step="0.01" min="0"
                    class="mt-1 block w-full rounded">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Making Charge Type</label>
                <select name="making_charge_type" class="mt-1 block w-full rounded border" required>
                    <option value="fixed">Fixed</option>
                    <option value="percentage">Percentage</option>
                </select>
            </div>

            <div id="fixed-making" class="mt-2 hidden">
                <label class="block text-sm font-medium mb-1">Making Charge (₹)</label>
                <input type="number" name="making_charge_rate" step="0.01" min="0"
                    required class="mt-1 block w-full rounded">
            </div>

            <div id="percentage-making" class="mt-2 hidden">
                <label class="block text-sm font-medium mb-1">Making Charge (%)</label>
                <input type="number" name="making_charge_rate" step="0.01" min="0"
                    required class="mt-1 block w-full rounded">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Stone Charge (₹)</label>
                <input type="number" name="stone_charge" step="0.01" min="0"
                    class="mt-1 block w-full rounded">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">GST Rate (%)</label>
                <input type="number" name="gst_rate" step="0.01" min="0" max="28" value="3"
                    required class="mt-1 block w-full rounded">
            </div>
        </form>

        <div id="result" class="mt-6 p-4 bg-green-50 rounded hidden">
            <h3 class="font-medium mb-2">Price Breakdown</h3>
            <p>Subtotal: <span id="subtotal">₹0.00</span></p>
            <p>CGST ({{ $gst_rate }}%): <span id="cgst">₹0.00</span></p>
            <p>SGST ({{ $gst_rate }}%): <span id="sgst">₹0.00</span></p>
            <p class="font-bold mt-2">Grand Total: <span id="grand_total">₹0.00</span></p>
        </div>
    </div>
</div>

<script>
document.getElementById('priceForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = {
        metal_type: e.target.metal_type.value,
        purity: e.target.purity.value,
        gross_weight: parseFloat(e.target.gross_weight.value),
        stone_weight: parseFloat(e.target.stone_weight.value || 0),
        making_charge_type: e.target.making_charge_type.value,
        making_charge_rate: parseFloat(e.target.making_charge_rate.value),
        stone_charge: parseFloat(e.target.stone_charge.value || 0),
        gst_rate: parseFloat(e.target.gst_rate.value),
    };

    try {
        const response = await fetch('/pos/calculate', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: JSON.stringify(formData)
        });
        const data = await response.json();

        document.getElementById('subtotal').textContent = '₹' + data.subtotal.toFixed(2);
        document.getElementById('cgst').textContent = '₹' + data.cgst_amount.toFixed(2);
        document.getElementById('sgst').textContent = '₹' + data.sgst_amount.toFixed(2);
        document.getElementById('grand_total').textContent = '₹' + data.grand_total.toFixed(2);
        document.getElementById('result').classList.remove('hidden');
        document.getElementById('result').classList.add('bg-green-50');
    } catch (error) {
        alert('Error calculating price');
    }
});
</script>
@endsection