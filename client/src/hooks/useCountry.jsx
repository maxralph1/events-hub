import { useState, useEffect } from 'react'
import { useNavigate } from 'react-router-dom'
import { route } from '@/routes'
 
export function useCountry(id = null) {
    const [errors, setErrors] = useState({})
    const [loading, setLoading] = useState(false)
    const [data, setData] = useState({})
    const navigate = useNavigate()
    
    useEffect(() => {
        if (id !== null) {
            const controller = new AbortController()
            getCountry(id, { signal: controller.signal })
            return () => controller.abort()
        }
    }, [id])
    
    async function createCountry(country) {
        setLoading(true)
        setErrors({})
    
        return axios.post('super-admin/countries', country)
        .then(() => navigate(route('countries.index')))
        .catch(error => {
            if (error.response.status === 422) {
                setErrors(error.response.data.errors)
            }
        })
        .finally(() => setLoading(false))
    }
    
    async function getCountry(id, { signal } = {}) {
        setLoading(true)
    
        return axios.get(`super-admin/countries/${id}`, { signal })
        .then(response => setData(response.data.data))
        .catch(() => {})
        .finally(() => setLoading(false))
    }
    
    async function updateCountry(country) {
        setLoading(true)
        setErrors({})
    
        return axios.put(`super-admin/countries/${country.id}`, country)
        .then(() => navigate(route('countries.index')))
        .catch(error => {
            if (error.response.status === 422) {
                setErrors(error.response.data.errors)
            }
        })
        .finally(() => setLoading(false))
    }
    
    async function destroyCountry(country) {
        return axios.delete(`super-admin/countries/${country.id}`)
    }
    
    return {
        country: { data, setData, errors, loading },
        createCountry,
        updateCountry,
        destroyCountry,
    }
}