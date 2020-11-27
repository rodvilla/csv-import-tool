<template>
<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div
      v-if="mappingsError !== ''"
      class="p-3 rounded-lg mb-3 bg-yellow-200"
    >{{ mappingsError }}</div>
    <div class="px-4 py-3 sm:px-4">
        <h3 class="text-lg leading-6 font-medium text-gray-900">Map fields</h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500 mt-2">
            Found {{ rowsCount }}  rows in file <span class="font-bold">{{ fileName }}</span>
        </p>
    </div>
    <div class="border-t border-gray-200">
        <dl>
            <div class="bg-white px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">Spreadsheet Field</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">Database Field</dd>
            </div>
            <div
                v-for="(header, index) in csvHeaders"
                :key="index"
                class="bg-gray-50 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
            >
                <dt class="text-sm font-medium text-gray-500 pt-3">{{ header }}</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    <select
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        v-model="mappings[index]"
                    >
                        <option value="custom">Custom attribute</option>
                        <option
                            v-for="(label, key) in columnsMap"
                            :key="key"
                            :value="key"
                        >
                            {{ label }}
                        </option>
                  </select>
                </dd>
            </div>
        </dl>
        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
            <button
                type="submit"
                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                v-on:click.prevent="applyMappings()"
            >
                Save
            </button>
        </div>
    </div>
</div>
</template>
<script>
export default {
    props: [
        'fileName',
        'rowsCount',
        'columnsMap',
        'csvHeaders',
        'mappingsError'
    ],

    data() {
        return {
            mappings: []
        }
    },

    beforeMount() {
        this.csvHeaders.forEach((header, index) => {
            this.mappings[index] = "custom";
        });
    },
    
    methods: {
        applyMappings() {
            this.$emit('mappingsSaved', this.mappings)
        }
    }
};
</script>