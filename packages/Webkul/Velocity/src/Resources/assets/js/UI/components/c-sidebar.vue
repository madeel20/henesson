<template>
    <div>
    <!-- categories list -->
    <div id="sidebar-backdrop" :class="`sidebar-backdrop ${addClass ? 'show' : ''}`"></div>
    <nav
        :id="id"
        @mouseover="remainBar(id)"
        :class="`c-sidebar ${addClass ? addClass : ''}`"
        v-if="slicedCategories && slicedCategories.length > 0">
        <div class="c-sidebar-content">
        <img onClick="$('#c-sidebar, #sidebar-backdrop').removeClass('show')" class="cross-icon" :src="`${$root.baseUrl}/themes/velocity/assets/images/cross-sign.png`" />
        <div class="profile" >
            <img class="profile-icon" :src="`${$root.baseUrl}/themes/velocity/assets/images/profile-icon.png`" />
            <span class="profile-title "> Hello, Faizan</span>
        </div>
        <ul class="category-list" type="none" v-if="selectedParentCategory===null">
            <h2> SHOP BY CATEGORY </h2>
            <li
                :key="categoryIndex"
                :id="`category-${category.id}`"
                class="category-content cursor-pointer"
                v-for="(category, categoryIndex) in slicedCategories"

            >
               <div
                    class="category unset">
<!--                    <div-->
<!--                        class="category-icon"-->
<!--                        @mouseout="toggleSidebar(id, $event, 'mouseout')"-->
<!--                        @mouseover="toggleSidebar(id, $event, 'mouseover')"-->
<!--                    >-->
<!--                        <img-->
<!--                            v-if="category.category_icon_path"-->
<!--                            :src="`${$root.baseUrl}/storage/${category.category_icon_path}`" />-->
<!--                    </div>-->
                   <a
                       :href="`${$root.baseUrl}/${category.slug}`"><span class="category-title">{{ category['name'] }}</span></a>
                   <img class="arrow-icon" :src="`${$root.baseUrl}/themes/velocity/assets/images/arrow-icon.png`"
                        @click="selectAParentCategory(category)"
                        v-if="category.children.length && category.children.length > 0"
                   />
                </div>
            </li>
        </ul>
            <div class="category-list"   v-else>
                <div class="back-icon-container">
                    <img @click="selectAParentCategory(null)" class="icon" :src="`${$root.baseUrl}/themes/velocity/assets/images/left-arrow.png`" />
                    <h2>{{selectedParentCategory['name']}}</h2>
                </div>
            <div
                class="sub-category-container"
            >
                <div
                    class="sub-categories cursor-default">
                    <ul type="none">
                        <li
                            :key="`${subCategoryIndex}`"
                            v-for="(subCategory, subCategoryIndex) in selectedParentCategory.children">
                            <a
                                :id="`sidebar-level-link-2-${subCategoryIndex}`"
                                @mouseout="toggleSidebar(id, $event, 'mouseout')"
                                :href="`${$root.baseUrl}/${selectedParentCategory.slug}/${selectedParentCategory.slug}`"
                                :class="`category sub-category unset ${(selectedParentCategory.children.length > 0) ? 'fw6' : ''}`">

                                <div
                                    class="category-icon"
                                    @mouseout="toggleSidebar(id, $event, 'mouseout')"
                                    @mouseover="toggleSidebar(id, $event, 'mouseover')">

                                    <img
                                        v-if="selectedParentCategory.category_icon_path"
                                        :src="`${$root.baseUrl}/storage/${subCategory.category_icon_path}`" />
                                </div>
                                <span class="category-title">{{ subCategory['name'] }}</span>
                            </a>

                            <ul type="none" class="nested">
                                <li
                                    :key="`${childSubCategoryIndex}-${subCategoryIndex}`"
                                    v-for="(childSubCategory, childSubCategoryIndex) in subCategory.children">

                                    <a
                                        :id="`sidebar-level-link-3-${childSubCategoryIndex}`"
                                        :class="`category unset ${(subCategory.children.length > 0) ? 'fw6' : ''}`"
                                        :href="`${$root.baseUrl}/${selectedParentCategory.slug}/${subCategory.slug}/${childSubCategory.slug}`">
                                        <span class="category-title">{{ childSubCategory.name }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            </div>
        </div>
    </nav>
    </div>

</template>

<script type="text/javascript">
    export default {
        props: [
            'id',
            'addClass',
            'parentSlug',
            'mainSidebar',
            'categoryCount'
        ],

        data: function () {
            return {
                slicedCategories: [],
                sidebarLevel: Math.floor(Math.random() * 1000),
                selectedParentCategory:null
            }
        },

        watch: {
            '$root.sharedRootCategories': function (categories) {
                this.formatCategories(categories);
            }
        },

        methods: {
            remainBar: function (id) {
                let sidebar = $(`#${id}`);
                if (sidebar && sidebar.length > 0) {
                    sidebar.show();

                    let actualId = id.replace('sidebar-level-', '');

                    let sidebarContainer = sidebar.closest(`.sub-category-${actualId}`)
                    if (sidebarContainer && sidebarContainer.length > 0) {
                        sidebarContainer.show();
                    }

                }
            },

            formatCategories: function (categories) {
                let slicedCategories = categories;
                let categoryCount = this.categoryCount ? this.categoryCount : 9;

                if (
                    slicedCategories
                    && slicedCategories.length > categoryCount
                ) {
                    slicedCategories = categories.slice(0, categoryCount);
                }

                if (this.parentSlug)
                    slicedCategories['parentSlug'] = this.parentSlug;

                this.slicedCategories = slicedCategories;
            },
            selectAParentCategory: function (category) {
                this.selectedParentCategory = category;
            }
        }
    }
</script>