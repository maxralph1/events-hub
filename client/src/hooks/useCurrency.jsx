import { useState, useEffect } from 'react'
import { useNavigate } from 'react-router-dom'
import { route } from '@/routes'
 
export function useCurrency(id = null) {
    const [errors, setErrors] = useState({})
    const [loading, setLoading] = useState(false)
    const [data, setData] = useState({})
    const navigate = useNavigate()
    
    useEffect(() => {
        if (id !== null) {
            const controller = new AbortController()
            getCurrency(id, { signal: controller.signal })
            return () => controller.abort()
        }
    }, [id])
    
    async function createCurrency(currency) {
        setLoading(true)
        setErrors({})
    
        return axios.post('super-admin/currencies', currency)
        .then(() => navigate(route('currencies.index')))
        .catch(error => {
            if (error.response.status === 422) {
                setErrors(error.response.data.errors)
            }
        })
        .finally(() => setLoading(false))
    }
    
    async function getCurrency(id, { signal } = {}) {
        setLoading(true)
    
        return axios.get(`super-admin/currencies/${id}`, { signal })
        .then(response => setData(response.data.data))
        .catch(() => {})
        .finally(() => setLoading(false))
    }
    
    async function updateCurrency(currency) {
        setLoading(true)
        setErrors({})
    
        return axios.put(`super-admin/currencies/${currency.id}`, currency)
        .then(() => navigate(route('currencies.index')))
        .catch(error => {
            if (error.response.status === 422) {
                setErrors(error.response.data.errors)
            }
        })
        .finally(() => setLoading(false))
    }
    
    async function destroyCurrency(currency) {
        return axios.delete(`super-admin/currencies/${currency.id}`)
    }
    
    return {
        currency: { data, setData, errors, loading },
        createCurrency,
        updateCurrency,
        destroyCurrency,
    }
}