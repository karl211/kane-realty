// plugins/vue-format-global.js
import createNumberMask from 'text-mask-addons/dist/createNumberMask';
import Vue from 'vue'

const mixin = {
    data: vm => ({
        currencyMask: createNumberMask({
            prefix: '',
            allowDecimal: false,
            includeThousandsSeparator: true,
            allowNegative: false,
            allowLeadingZeroes: false
        }),
    }),
    watch: {
        form() {
            this.clear()
        },
        
        errors (errors) {
            if (errors) {
                for (const key in this.error) {
                    for (const key2 in errors) {
                        const subKey = key2.replace(`${this.componentName}.`,'')
                        const splitKey = subKey.split(".")
                        
                        if (splitKey.length > 1) {
                            if (key === splitKey[0] && this.componentName === 'chooseProperty') {
                                this.$set(this.error, splitKey[1], errors[key2])
                            } else if (key === subKey) {
                                this.error[key] = errors[key2]
                            }
                        }
                    }
                }
            }
        },
    },

    created () {
        if (this.form && this.error) {
            for (const key in this.form) {
                if (
                    typeof this.form[key] === 'object' &&
                    !Array.isArray(this.form[key]) &&
                    this.form[key] !== null
                ) {
                    const nestedObj = this.form[key];
                    const obj = {}
    
                    for (const key2 in nestedObj) {
                        obj[key2] = null
                        this.error[key] = obj
                    }
                } else {
                    this.$set(this.error, key, null)
                }
            }
        }
        
    },

    methods: {
        clear () {
            for (const key in this.error) {
                if (
                    typeof this.error[key] === 'object' &&
                    !Array.isArray(this.error[key]) &&
                    this.error[key] !== null
                ) {
                    const nestedObj = this.error[key];

                    for (const key in nestedObj) {
                        nestedObj[key] = null
                    }
                } else {
                    this.error[key] = null
                }
            }
        },

        formatDate (date) {
            if (!date) return null

            const [year, month, day] = date.split('-')
            return `${year}-${month}-${day}`
        },

        formatAmount (amount) {
            if (!amount) return null

            if (typeof amount === 'string') {
                return amount.replaceAll(',', '')
            }

            return amount
        },

        url (key) {
            if (!this.form[key]) return;
            return URL.createObjectURL(this.form[key]);
        },

        formatCurrency (money) {
            if (Number(money)) {
                return '₱' + Number(money).toLocaleString()
            }
            return money
        }
    }
}

Vue.mixin(mixin)