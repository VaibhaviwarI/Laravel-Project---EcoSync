@extends('layouts.app')

@section('title', 'Education & Segregation - EcoSync')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Waste Segregation Education</h1>
        <p style="color: var(--text-secondary); margin-top: 0.25rem;">Learn how to segregate waste and minimize landfill dumps</p>
    </div>
</div>

<!-- Dynamic Search Helper -->
<div class="glass-panel edu-card" style="margin-bottom: 2.5rem; border-color: rgba(6,182,212,0.18);">
    <h3 class="panel-title" style="color: var(--secondary); margin-bottom: 0.5rem;">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        Instant Segregation Helper
    </h3>
    <p style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 1.25rem;">Type any household item below to instantly learn which bin it goes in!</p>
    
    <div style="position: relative;">
        <input type="text" id="waste-search" class="form-control" placeholder="Type an item (e.g. apple, paper box, battery, bulb...)" style="padding-right: 3rem; font-size: 1.1rem; border-color: var(--secondary);">
    </div>
    
    <!-- Search Result Display Box -->
    <div id="search-result" style="display: none; margin-top: 1.25rem; padding: 1rem 1.5rem; border-radius: 10px; transition: var(--transition);">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div>
                <strong id="result-item" style="font-size: 1.1rem; font-family: var(--font-outfit);">Banana Peel</strong>
                <span style="color: var(--text-secondary); margin: 0 0.5rem;">goes into</span>
                <span id="result-bin" class="badge">Wet Waste</span>
            </div>
            <div id="result-tip" style="font-size: 0.88rem; color: var(--text-secondary); font-style: italic;">
                Compostable organic matter.
            </div>
        </div>
    </div>
</div>

<!-- Grid showing Waste Types -->
<div class="edu-grid">
    <!-- Dry Waste -->
    <div class="glass-panel edu-item">
        <div class="edu-icon-container">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2"><polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
        </div>
        <h4 class="edu-title" style="color: var(--primary);">Dry Waste (Recyclable)</h4>
        <p class="edu-desc" style="margin-bottom: 1rem;">Non-biodegradable waste items that can be processed and reused. Keep them dry and clean.</p>
        <div style="background: rgba(255,255,255,0.02); padding: 0.75rem; border-radius: 8px; text-align: left; font-size: 0.85rem;">
            <strong>Examples:</strong> Plastics, paper packages, cardboard boxes, aluminum cans, glass jars, copper wires.
        </div>
    </div>

    <!-- Wet Waste -->
    <div class="glass-panel edu-item wet">
        <div class="edu-icon-container">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--secondary)" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        </div>
        <h4 class="edu-title" style="color: var(--secondary);">Wet Waste (Biodegradable)</h4>
        <p class="edu-desc" style="margin-bottom: 1rem;">Organic waste matter that decomposes naturally. Excellent for campus composting initiatives.</p>
        <div style="background: rgba(255,255,255,0.02); padding: 0.75rem; border-radius: 8px; text-align: left; font-size: 0.85rem;">
            <strong>Examples:</strong> Fruit peels, vegetable scraps, left-over food, tea bags, egg shells, dead leaves, garden clippings.
        </div>
    </div>

    <!-- Hazardous & E-Waste -->
    <div class="glass-panel edu-item hazardous">
        <div class="edu-icon-container">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--danger)" stroke-width="2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        </div>
        <h4 class="edu-title" style="color: var(--danger);">Hazardous & E-Waste</h4>
        <p class="edu-desc" style="margin-bottom: 1rem;">Materials containing toxic substances or components. Must be collected and disposed of separately.</p>
        <div style="background: rgba(255,255,255,0.02); padding: 0.75rem; border-radius: 8px; text-align: left; font-size: 0.85rem;">
            <strong>Examples:</strong> Batteries, fluorescent tubes, expired medicine, electronics, chargers, phone adapters, chemical cleaners.
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const wasteDatabase = {
        'apple': { bin: 'Wet Waste', class: 'badge-resolved', tip: 'Compostable organic food scrap.' },
        'banana': { bin: 'Wet Waste', class: 'badge-resolved', tip: 'Fruit peel decomposes in 2-5 weeks.' },
        'vegetable': { bin: 'Wet Waste', class: 'badge-resolved', tip: 'Organic kitchen waste.' },
        'food': { bin: 'Wet Waste', class: 'badge-resolved', tip: 'Ensure all plastic packaging is removed.' },
        'tea bag': { bin: 'Wet Waste', class: 'badge-resolved', tip: 'Decomposes naturally.' },
        
        'plastic': { bin: 'Dry Waste', class: 'badge-progress', tip: 'Ensure it is rinsed clean and dry before disposal.' },
        'bottle': { bin: 'Dry Waste', class: 'badge-progress', tip: 'Recyclable. Eligible for Eco-Points!' },
        'paper': { bin: 'Dry Waste', class: 'badge-progress', tip: 'Keep paper dry to preserve fiber quality.' },
        'cardboard': { bin: 'Dry Waste', class: 'badge-progress', tip: 'Flatten boxes to save bin space.' },
        'can': { bin: 'Dry Waste', class: 'badge-progress', tip: 'Metal cans are infinitely recyclable.' },
        'metal': { bin: 'Dry Waste', class: 'badge-progress', tip: 'Highly recyclable. Upload for points.' },
        'glass': { bin: 'Dry Waste', class: 'badge-progress', tip: 'Glass can be recycled indefinitely without losing purity.' },
        
        'battery': { bin: 'Hazardous Waste', class: 'badge-pending', tip: 'Contains heavy metals. NEVER throw in regular bin.' },
        'phone': { bin: 'E-Waste', class: 'badge-pending', tip: 'Electronic circuitry contains toxic materials. Hand over separately.' },
        'laptop': { bin: 'E-Waste', class: 'badge-pending', tip: 'High recyclability of metals, but must be safely dismantled.' },
        'charger': { bin: 'E-Waste', class: 'badge-pending', tip: 'Cables and adapters are E-Waste.' },
        'bulb': { bin: 'Hazardous Waste', class: 'badge-pending', tip: 'Fluorescent bulbs contain mercury vapor.' },
        'medicine': { bin: 'Hazardous Waste', class: 'badge-pending', tip: 'Expired pharmaceutical products.' }
    };

    const searchInput = document.getElementById('waste-search');
    const resultBox = document.getElementById('search-result');
    const resultItem = document.getElementById('result-item');
    const resultBin = document.getElementById('result-bin');
    const resultTip = document.getElementById('result-tip');

    searchInput.addEventListener('input', function() {
        const query = searchInput.value.toLowerCase().trim();
        
        if (query.length < 2) {
            resultBox.style.display = 'none';
            return;
        }

        let found = null;
        for (let key in wasteDatabase) {
            if (query.includes(key) || key.includes(query)) {
                found = { name: key.toUpperCase(), ...wasteDatabase[key] };
                break;
            }
        }

        if (found) {
            resultItem.textContent = found.name;
            resultBin.textContent = found.bin;
            resultBin.className = 'badge ' + found.class;
            resultTip.textContent = found.tip;
            resultBox.style.backgroundColor = 'rgba(255, 255, 255, 0.03)';
            resultBox.style.border = '1px solid rgba(255, 255, 255, 0.08)';
            resultBox.style.display = 'block';
        } else {
            resultItem.textContent = query.toUpperCase();
            resultBin.textContent = 'General Bin';
            resultBin.className = 'badge badge-priority-low';
            resultTip.textContent = 'Unsure? Place in dry waste if dry, wet waste if food-based, or consult admin.';
            resultBox.style.backgroundColor = 'rgba(239, 68, 68, 0.05)';
            resultBox.style.border = '1px solid rgba(239, 68, 68, 0.15)';
            resultBox.style.display = 'block';
        }
    });
});
</script>
@endsection
