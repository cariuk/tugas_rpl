import {ref} from "vue"
import Axios from "axios"
import qs from 'qs'
import {router} from '@inertiajs/vue3'
// import {showNotification} from "@/composables/Notification"

const parseParams = (params) => {
    if (params !== undefined) {
        const keys = Object.keys(params);
        let options = '';

        keys.forEach((key) => {
            const isParamTypeObject = typeof params[key] === 'object';
            const isParamTypeArray = isParamTypeObject && (params[key].length >= 0);

            if (!isParamTypeObject) {
                options += `${key}=${params[key]}&`;
            }

            if (isParamTypeObject && isParamTypeArray) {
                params[key].forEach((element) => {
                    options += `${key}=${element}&`;
                });
            }
        });

        return options ? options.slice(0, -1) : options;
    } else
        return ''
};

export function get(url, request, notification = true) {
    let result = ref({})
    let parse = parseParams(request)
    return Axios.get(url, {
        params: request,
        paramsSerializer: {
            serialize: (params) => qs.stringify(params, {arrayFormat: 'brackets'})
        },
    }).then((response) => {
        result.value = response.data
        return response.data
    }).catch(error => {
        result.value = error.response.data
        if (notification)
            _handleError(error)
    })
}

export async function post(url, params, progress = false, multipart = [], notification = true) {
    let result = ref({});
    let options = {
        onUploadProgress: progress
    };
    if (multipart.length) {
        const formData = new FormData();
        for (let key in params) {
            if (multipart.includes(key)) {
                if (params[key] instanceof Blob)
                    formData.append(key + "_file", params[key], params[key].name)
            } else {
                if ((Array.isArray(params[key])) || (typeof params[key] === 'object')) {
                    formData.append(key, JSON.stringify(params[key]))
                } else {
                    formData.append(key, params[key])
                }

            }
        }
        params = formData;
        options.headers = {
            "Content-Type": "multipart/form-data",
        }
    }

    await Axios.post(url, params, options).then((response) => {
        result.value = response
        if (response.data.callback.notification) {
            let notify = response.data.callback.notification
            // showNotification(notify.title, notify.message)
        }

        if (response.data.callback.redirect) {
            _handleRedirectPage(response.data.callback.redirect)
        }
    }).catch(error => {
        if (error.response?.data) {
            result.value = error.response.data
            if (notification)
                _handleError(error)
        }
    })
    return result
}

export async function del(url, params) {
    let result = ref({});
    await Axios.delete(url, params).then((response) => {
        result.value = response
        if (response.data.callback.notification) {
            let notify = response.data.callback.notification
            showNotification(notify.title, notify.message)
        }
    }).catch(error => {
        if (error.response?.data) {
            result.value = error.response.data
            _handleError(error)
        }
    })

    return result
}

export function handleValidationMessage(result, errVariable) {
    if (result.error) {
        Object.keys(result.error).map((key) => {
            errVariable[key] = result.error[key].toString();
        })
    }
    return errVariable
}

function _handleRedirectPage(redirect) {
    router.visit(redirect.url, redirect.params)
}

function _handleError(error) {
    if (error.response.status === 422 && showNotification){
        //showNotification(error.response.data.title ?? '', error.response.data.message, 'warning')
        return false;
    } else {
        let statusUnauthorized = [401, 419]

        if (statusUnauthorized.includes(error.response.status))
            router.reload({})

        //showNotification(error.response.data.title ?? '', error.response.data.message, 'error')
    }
}
