@extends('layouts.main')

@section('title')
    {{ __('Article') }}
@endsection

@section('page-title')
<div class="page-title">
	<div class="row">
		<div class="col-12 col-md-6 order-md-1 order-last">
			<h4>@yield('title')</h4>
		</div>
		<div class="col-12 order-first article_header">
            @if (has_permissions('create', 'article'))
                <a href="{{url('add_article') }}" class="btn btn-primary btn_add">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z">
                        </path>
                    </svg>
                    {{ __('Add Article') }}
                </a>
            @endif
		</div>
	</div>
</div>
@endsection


@section('content')
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <table class="table table-striped"
                            id="table_list" data-toggle="table" data-url="{{ route('article_list') }}"
                            data-click-to-select="true" data-responsive="true" data-side-pagination="server"
                            data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true"
                            data-toolbar="#toolbar" data-show-columns="true" data-show-refresh="true"
                            data-trim-on-search="false" data-sort-name="id" data-sort-order="desc"
                            data-pagination-successively-size="3" data-query-params="queryParams">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col" data-field="id" data-sortable="true">{{ __('ID') }}</th>
                                    <th scope="col" data-field="title" data-sortable="true">{{ __('Title') }}</th>
                                    <th scope="col" data-field="description" data-formatter="descriptionFormatter" data-sortable="true" style="max-width: 300px;">{{ __('Description') }}</th>
                                    <th scope="col" data-field="category_title" data-sortable="false">{{ __('Category Title') }}</th>
                                    <th scope="col" data-field="view_count" data-sortable="true" data-align="center">{{ __('View Count') }}</th>
                                    <th scope="col" data-field="image" data-formatter="imageFormatter" data-sortable="false" data-align="center">{{ __('Image') }}</th>
                                    <th scope="col" data-field="meta_title" data-sortable="false" data-visible="false">{{ __('Meta Title') }}</th>
                                    <th scope="col" data-field="meta_description" data-sortable="false" data-visible="false">{{ __('Meta Description') }}</th>
                                    @if (has_permissions('update', 'article') || has_permissions('delete', 'article'))
                                        <th scope="col" data-field="operate" data-sortable="false" data-align="center"> {{ __('Action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Description Modal -->
    <div class="modal fade" id="descriptionModal" tabindex="-1" aria-labelledby="descriptionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="descriptionModalLabel">{{ __('Article Description') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="modalDescriptionContent"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
    function queryParams(p) {
        return {
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            limit: p.limit,
            search: p.search,
            status: $('#status').val(),
            category: $('#category').val(),
            customer_id: $('#customerid').val(),
        };
    }

    // Custom formatter for description column
    function descriptionFormatter(value, row, index) {
        if (!value) return '-';
        
        // Strip HTML tags for length calculation
        const textOnly = value.replace(/<[^>]*>/g, '');
        const maxLength = 100;
        
        if (textOnly.length <= maxLength) {
            return `<div class="description-cell">${value}</div>`;
        }
        
        // Truncate HTML content more intelligently
        const truncated = truncateHtml(value, maxLength);
        
        return `
            <div class="description-cell">
                <div class="description-preview">${truncated}...</div>
                <button type="button" class="btn btn-link btn-sm p-0 mt-1 read-more-btn" 
                        onclick="showFullDescription('${encodeURIComponent(value)}')" 
                        title="{{ __('Click to read full description') }}">
                    <i class="bi bi-eye"></i> {{ __('Read More') }}
                </button>
            </div>
        `;
    }

    // Function to truncate HTML content intelligently
    function truncateHtml(html, maxLength) {
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = html;
        const text = tempDiv.textContent || tempDiv.innerText || '';
        
        if (text.length <= maxLength) {
            return html;
        }
        
        // Simple truncation - you might want to use a more sophisticated library
        const truncated = text.substring(0, maxLength);
        return truncated;
    }

    // Function to show full description in modal
    function showFullDescription(encodedDescription) {
        const description = decodeURIComponent(encodedDescription);
        document.getElementById('modalDescriptionContent').innerHTML = description;
        
        // Show modal (Bootstrap 5 syntax)
        const modal = new bootstrap.Modal(document.getElementById('descriptionModal'));
        modal.show();
    }
</script>

<style>
    .description-cell {
        max-width: 300px;
        word-wrap: break-word;
    }
    
    .description-preview {
        line-height: 1.4;
    }
    
    .read-more-btn {
        font-size: 0.85rem;
        color: #0d6efd !important;
        text-decoration: none;
    }
    
    .read-more-btn:hover {
        text-decoration: underline !important;
    }
    
    #descriptionModal .modal-body {
        max-height: 60vh;
        overflow-y: auto;
    }
</style>
@endsection
