import { defaultConfig } from '@formkit/vue'
import { rootClasses } from './formkit.theme.js'
import { generateClasses } from '@formkit/themes'

export default defaultConfig({
    config: {
        rootClasses,
        classes: generateClasses({
            global: { // applies to all input types
                outer: 'max-w-full',
            },
        }),
    },
})
