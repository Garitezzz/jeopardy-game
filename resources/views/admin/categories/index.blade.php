{{--
    Categories Index View
    
    List all categories with drag-and-drop reordering.
    Provides actions to create, edit, and delete categories.
--}}
{{-- Extend admin layout --}}
@extends('layouts.admin')

{{-- Set page title --}}
@section('title', 'Categories')

{{-- Main content --}}
@section('content')
{{-- Page header with title and add button --}}
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1>Categories</h1>
            <p>Manage game categories</p>
        </div>
        {{-- Button to create new category --}}
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">+ Add Category</a>
    </div>
</div>

{{-- Card containing categories table or empty message --}}
<div class="card">
    {{-- Check if categories exist --}}
    @if($categories->count() > 0)
        {{-- Instruction text for drag-and-drop --}}
        <p style="margin-bottom: 15px; color: #7f8c8d;">💡 Drag and drop to reorder categories</p>
        {{-- Table displaying all categories --}}
        <table>
            <thead>
                <tr>
                    <th width="60">Order</th>
                    <th>Category Name</th>
                    <th>Description</th>
                    <th>Questions</th>
                    <th width="200">Actions</th>
                </tr>
            </thead>
            {{-- Table body with draggable rows --}}
            <tbody id="categories-list">
                {{-- Loop through each category --}}
                @foreach($categories as $category)
                {{-- Draggable table row with category data --}}
                <tr class="draggable" data-id="{{ $category->id }}" draggable="true">
                    {{-- Display category order number --}}
                    <td><strong>{{ $category->order }}</strong></td>
                    {{-- Display category name --}}
                    <td><strong>{{ $category->name }}</strong></td>
                    {{-- Display category description --}}
                    <td>{{ $category->description }}</td>
                    {{-- Display count of questions in this category --}}
                    <td>{{ $category->questions_count }} questions</td>
                    {{-- Action buttons column --}}
                    <td>
                        <div class="action-buttons">
                            {{-- Edit button links to edit page --}}
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning">Edit</a>
                            {{-- Delete form with confirmation dialog --}}
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this category and all its questions?');">
                                @csrf
                                {{-- Method spoofing for DELETE request --}}
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        {{-- Empty state message when no categories exist --}}
        <p style="color: #7f8c8d; text-align: center; padding: 40px;">
            No categories yet. <a href="{{ route('admin.categories.create') }}">Create your first category</a>
        </p>
    @endif
</div>
@endsection

{{-- Scripts section for drag-and-drop functionality --}}
@section('scripts')
<script>
{{-- Wait for DOM to be ready --}}
document.addEventListener('DOMContentLoaded', function() {
    {{-- Get the table body element --}}
    const tbody = document.getElementById('categories-list');
    if (!tbody) return;
    
    {{-- Variable to store currently dragged element --}}
    let draggedElement = null;
    
    {{-- Add drag event listeners to all draggable rows --}}
    tbody.querySelectorAll('.draggable').forEach(row => {
        {{-- When drag starts, store reference and add visual class --}}
        row.addEventListener('dragstart', function(e) {
            draggedElement = this;
            this.classList.add('dragging');
        });
        
        {{-- When drag ends, remove visual class and update order on server --}}
        row.addEventListener('dragend', function(e) {
            this.classList.remove('dragging');
            updateOrder();
        });
        
        {{-- Handle drag over to reposition elements --}}
        row.addEventListener('dragover', function(e) {
            e.preventDefault();
            const afterElement = getDragAfterElement(tbody, e.clientY);
            if (afterElement == null) {
                tbody.appendChild(draggedElement);
            } else {
                tbody.insertBefore(draggedElement, afterElement);
            }
        });
    });
    
    {{-- Helper function to determine where to insert dragged element --}}
    function getDragAfterElement(container, y) {
        const draggableElements = [...container.querySelectorAll('.draggable:not(.dragging)')];
        
        return draggableElements.reduce((closest, child) => {
            const box = child.getBoundingClientRect();
            const offset = y - box.top - box.height / 2;
            
            if (offset < 0 && offset > closest.offset) {
                return { offset: offset, element: child };
            } else {
                return closest;
            }
        }, { offset: Number.NEGATIVE_INFINITY }).element;
    }
    
    {{-- Send updated order to server via AJAX --}}
    function updateOrder() {
        const rows = tbody.querySelectorAll('.draggable');
        const categories = [];
        
        {{-- Build array of category IDs with new order numbers --}}
        rows.forEach((row, index) => {
            categories.push({
                id: row.dataset.id,
                order: index + 1
            });
        });
        
        {{-- POST request to reorder route --}}
        fetch('{{ route("admin.categories.reorder") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ categories: categories })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
});
</script>
@endsection
