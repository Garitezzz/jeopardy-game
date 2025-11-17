@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1>Categories</h1>
            <p>Manage game categories</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">+ Add Category</a>
    </div>
</div>

<div class="card">
    @if($categories->count() > 0)
        <p style="margin-bottom: 15px; color: #7f8c8d;">💡 Drag and drop to reorder categories</p>
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
            <tbody id="categories-list">
                @foreach($categories as $category)
                <tr class="draggable" data-id="{{ $category->id }}" draggable="true">
                    <td><strong>{{ $category->order }}</strong></td>
                    <td><strong>{{ $category->name }}</strong></td>
                    <td>{{ $category->description }}</td>
                    <td>{{ $category->questions_count }} questions</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete this category and all its questions?');">
                                @csrf
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
        <p style="color: #7f8c8d; text-align: center; padding: 40px;">
            No categories yet. <a href="{{ route('admin.categories.create') }}">Create your first category</a>
        </p>
    @endif
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tbody = document.getElementById('categories-list');
    if (!tbody) return;
    
    let draggedElement = null;
    
    tbody.querySelectorAll('.draggable').forEach(row => {
        row.addEventListener('dragstart', function(e) {
            draggedElement = this;
            this.classList.add('dragging');
        });
        
        row.addEventListener('dragend', function(e) {
            this.classList.remove('dragging');
            updateOrder();
        });
        
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
    
    function updateOrder() {
        const rows = tbody.querySelectorAll('.draggable');
        const categories = [];
        
        rows.forEach((row, index) => {
            categories.push({
                id: row.dataset.id,
                order: index + 1
            });
        });
        
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
