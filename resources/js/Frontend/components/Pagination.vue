<template>
    <div class="pagination-area">
        <nav class="d-flex justify-items-center justify-content-between">
            <div class="d-flex justify-content-between flex-fill d-sm-none">
                <ul class="pagination">
                    <!-- Previous Page Link -->
                    <li
                        class="page-item"
                        :class="{ disabled: currentPage === 1 }"
                    >
                        <a
                            class="page-link"
                            href="#"
                            @click.prevent="previousPage"
                            aria-label="Previous"
                        >
                            Previous
                        </a>
                    </li>

                    <!-- Next Page Link -->
                    <li
                        class="page-item"
                        :class="{ disabled: currentPage === lastPage }"
                    >
                        <a
                            class="page-link"
                            href="#"
                            @click.prevent="nextPage"
                            aria-label="Next"
                        >
                            Next
                        </a>
                    </li>
                </ul>
            </div>

            <div
                class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between"
            >
                <div>
                    <p class="small text-muted">
                        Showing
                        <span class="fw-semibold">{{ firstItem }}</span>
                        to
                        <span class="fw-semibold">{{ lastItem }}</span>
                        of
                        <span class="fw-semibold">{{ total }}</span>
                        results
                    </p>
                </div>

                <div>
                    <ul class="pagination">
                        <!-- Previous Page Link -->
                        <li
                            class="page-item"
                            :class="{ disabled: currentPage === 1 }"
                        >
                            <a
                                class="page-link"
                                href="#"
                                @click.prevent="previousPage"
                                aria-label="Previous"
                            >
                                &lsaquo;
                            </a>
                        </li>

                        <!-- Pagination Elements -->
                        <li
                            v-for="page in displayedPages"
                            :key="page"
                            class="page-item"
                            :class="{ active: page === currentPage }"
                        >
                            <a
                                class="page-link"
                                href="#"
                                @click.prevent="gotoPage(page)"
                                >{{ page }}</a
                            >
                        </li>

                        <!-- Next Page Link -->
                        <li
                            class="page-item"
                            :class="{ disabled: currentPage === lastPage }"
                        >
                            <a
                                class="page-link"
                                href="#"
                                @click.prevent="nextPage"
                                aria-label="Next"
                            >
                                &rsaquo;
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</template>

<script>
export default {
    props: {
        currentPage: {
            type: Number,
            required: true,
        },
        lastPage: {
            type: Number,
            required: true,
        },
        firstItem: {
            type: Number,
            required: true,
        },
        lastItem: {
            type: Number,
            required: true,
        },
        total: {
            type: Number,
            required: true,
        },
    },
    data(){
        return {
            maxVisiblePages: 5,
        }
    },
    computed: {
        pages() {
            const pages = [];
            for (let i = 1; i <= this.lastPage; i++) {
                pages.push(i);
            }
            return pages;
        },
        displayedPages() {
            const halfVisible = Math.floor(this.maxVisiblePages / 2);
            let startPage = Math.max(1, this.currentPage - halfVisible);
            let endPage = Math.min(
                this.total,
                this.currentPage + halfVisible
            );

            // Ensure we always show 'maxVisiblePages' pages if possible
            if (endPage - startPage < this.maxVisiblePages - 1) {
                if (startPage === 1) {
                    endPage = Math.min(
                        this.total,
                        startPage + this.maxVisiblePages - 1
                    );
                } else {
                    startPage = Math.max(1, endPage - this.maxVisiblePages + 1);
                }
            }

            return Array.from(
                { length: endPage - startPage + 1 },
                (_, i) => startPage + i
            );
        },
    },
    emits: ['goto'],
    methods: {
        nextPage() {
            if (this.currentPage < this.lastPage) {
                this.$emit("goto", this.currentPage + 1);
            }
        },
        previousPage() {
            if (this.currentPage > 1) {
                this.$emit("goto", this.currentPage - 1);
            }
        },
        gotoPage(page) {
            this.$emit("goto", page);
        },
    },
};
</script>

<style></style>
