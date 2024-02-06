@php use App\Constants\RouteNames; @endphp
<div
    class="card mb-5 mt-5"
    x-data="{ apiData: {}, lastUrl: '', name:'', date:'' }"
    x-init="fetchData().then(result => apiData = result)"
>
    <h5 class="card-header">Customers</h5>
    <ul class="list-group list-group-flush">
        <template x-for="customer in apiData.data" :key="customer.id">
            <li class="list-group-item">
                <div class="row g-0">
                    <div class="col-md-10" @click="console.log('foo:bar')">
                        <a x-bind:href="'{{url('/customer')}}/'+customer.id" class="text-black text-decoration-none">
                            <p class="mb-0" x-text="customer.name"></p>
                            <small x-html="customer.last_interaction_date ?? '&nbsp;'"></small>
                        </a>
                    </div>
                    <div class="col-md-2 text-end">
                        <button
                            class="btn btn-outline-danger btn-sm"
                            @click="handleDeleteClick(customer.id).then(result => {console.log('refresing');fetchData(lastUrl).then(result => {console.log('done');apiData = result})})"
                        >Delete
                        </button>
                    </div>
                </div>
            </li>
        </template>
    </ul>
    <div class="card-body">
        <nav aria-label="...">
            <ul class="pagination mb-0">
                <template x-for="link in apiData.meta.links">
                    <li :class="link.active ? 'page-item active' : 'page-item'">
                        <template x-if="link.active">
                            <span class="page-link" x-html="link.label"></span>
                        </template>
                        <template x-if="! link.active">
                            <div>
                                <template x-if="link.url">
                                    <a
                                        class="page-link"
                                        href="#"
                                        x-html="link.label"
                                        @click="lastUrl=link.url; fetchData(link.url).then(result => {apiData = result})"
                                    ></a>
                                </template>
                                <template x-if="!link.url">
                                    <span class="page-link disabled" x-html="link.label"></span>
                                </template>
                            </div>
                        </template>
                    </li>
                </template>
            </ul>
        </nav>
    </div>
</div>

@push('scripts')
    <script>
        async function fetchData(url) {
            if (!url) {
                url = `{{URL::route(RouteNames::API_CUSTOMER_INDEX)}}`;
            }

            try {
                let init = {
                    method:  'GET',
                    headers: {
                        Accept:        'application/json',
                        Authorization: "Bearer {{$apiToken}}",
                    },
                    cache:   'no-cache',
                };

                let response = await fetch(url, init);
                let data     = await response.json();
                if (200 === response.status) {
                    return data;
                } else {
                    return {};
                }

            } catch (error) {
                console.error('Error fetching data:', error);
            }
        }

        async function handleDeleteClick(id) {
            let url = `{{URL::route(RouteNames::API_CUSTOMER_INDEX)}}/${id}`;

            try {
                let init = {
                    method:  'DELETE',
                    headers: {
                        Accept:        'application/json',
                        Authorization: "Bearer {{$apiToken}}",
                    },
                    cache:   'no-cache',
                };

                let response = await fetch(url, init);
                if (204 === response.status) {
                    console.log('deleted');
                    return true;
                }
            } catch (error) {
                console.log('Error deleting customer:', error);
                return false;
            }
        }
    </script>
@endpush
