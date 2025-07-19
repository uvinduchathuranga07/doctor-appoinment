<template>
    <AppLayout>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h5>Products</h5>
                        <p>Manage Products and Usage Information.</p>
                        <div class="d-flex">
                            <Link class="btn btn-main btn-sm" :href="route('product.create')"
                                  v-if="$root.hasPermission('product.create')">
                                <i class="bx bx-plus"></i> Create
                            </Link>
                        </div>
                    </div>
                    <div class="card-body">
                        <data-table ref="datatable" :url="route('product.getdata')"
                                    :columns="columns" :columnDefs="columnDefs">
                            <template #header>
                                <tr>
                                    <th width="10%">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="form-check-input" id="selectAll"
                                                   @click="selectAll($event)" />
                                            <label class="form-check-label" for="selectAll"></label>
                                        </div>
                                    </th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Stock</th>
                                    <th>Action</th>
                                </tr>
                            </template>
                        </data-table>
                    </div>
                </div>
            </div>

            <!-- delete confirm modal -->
            <div class="modal modal-top fade" id="deleteConfirm" tabindex="-1" aria-hidden="true" data-bs-backdrop="false">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header px-3 pb-2">
                            <h5 class="modal-title">Are You Sure?</h5>
                        </div>
                        <form @submit.prevent="deleteSelectedItems">
                            <div class="modal-body py-0 px-3">
                                <div class="row">
                                    <div class="col mb-1">
                                        <p>Are you sure you want to delete?</p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer px-3 pb-3">
                                <button type="button" class="btn btn-sm btn-label-secondary" data-bs-dismiss="modal"
                                        @click="resetForm">Close</button>
                                <button type="submit" class="btn btn-sm btn-primary">Yes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import { Link, useForm } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import DataTable from "@/Components/DataTable.vue";

export default {
    components: {
        Link,
        AppLayout,
        DataTable,
    },

    data() {
        return {
            columns: [
                {
                    data: "check",
                    name: "check",
                    orderable: false,
                    searchable: false,
                },
                {
                    data: "name",
                    name: "name",
                    orderable: true,
                    searchable: true,
                },
                {
                    data: "image",
                    name: "image",
                    orderable: false,
                    searchable: false,
                },
                {
                    data: "stock_count",
                    name: "stock_count",
                    orderable: true,
                },
                {
                    data: "action",
                    name: "action",
                    orderable: false,
                },
            ],
            columnDefs: [{ className: "text-center", targets: [] }],
            order: [[1, "desc"]],
            form: useForm({ id: "" }),
            selectedRows: [],
            isDisabled: true,
        };
    },

    mounted() {
        const self = this;

        $("#productTable tbody").on("click", "tr .action_edit", (evt) => {
            const id = $(evt.target).data("item-id");
            self.$inertia.visit(route("product.edit", id));
        });

        $("#productTable tbody").on("click", "tr .action_delete", (evt) => {
            const id = $(evt.target).data("item-id");
            self.selectedRows = [];
            self.getSelectedItems(id);
        });

        $("#productTable tbody").on("click", ".item-check input[type=checkbox]", (evt) => {
            const val = $(evt.target).val();
            if ($(evt.target).prop("checked") && !self.selectedRows.includes(val)) {
                self.getSelectedItems(val);
            } else {
                self.removeUnselectedItem(val);
            }
        });
    },

    methods: {
        reloadTable() {
            this.$refs.datatable.reloadDatatable();
        },
        getSelectedItems(value) {
            this.selectedRows.push(value);
            this.isDisabled = false;
        },
        selectAll(evt) {
            const self = this;
            if ($(evt.target).is(":checked")) {
                $(".item-check input[type=checkbox]").prop("checked", true);
                $(".item-check input[type=checkbox]:checked").each(function () {
                    if (!self.selectedRows.includes(this.value)) {
                        self.getSelectedItems(this.value);
                    }
                });
            } else {
                $(".item-check input[type=checkbox]").prop("checked", false);
                $(".item-check input[type=checkbox]").each(function () {
                    if (self.selectedRows.includes(this.value)) {
                        self.removeUnselectedItem(this.value);
                    }
                });
                self.isDisabled = true;
            }
        },
        removeUnselectedItem(value) {
            this.selectedRows = this.selectedRows.filter(val => val !== value);
            if (this.selectedRows.length <= 0) {
                $("#selectAll").prop("checked", false);
                this.isDisabled = true;
            }
        },
        deleteSelectedItems() {
            this.form.transform(data => ({
                ...data,
                ids: [...this.selectedRows],
            })).post(route("product.delete"), {
                onSuccess: () => {
                    this.resetForm();
                    this.reloadTable();
                    this.$root.showMessage("success", "Success", "Product(s) deleted.");
                },
                onError: () => {
                    this.$root.showMessage("error", "Error", "Something went wrong!");
                },
                onFinish: () => {
                    $("#deleteConfirm").modal("hide");
                    this.resetForm();
                },
            });
        },
        resetForm() {
            this.form.reset("id");
        },
    },
};
</script>
   