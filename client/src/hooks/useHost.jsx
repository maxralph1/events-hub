import { useState, useEffect } from 'react'
import { useNavigate } from 'react-router-dom'
import { route } from '@/routes'
 
export function useHost(id = null) {
    const [errors, setErrors] = useState({})
    const [loading, setLoading] = useState(false)
    const [data, setData] = useState({})
    const navigate = useNavigate()
    
    useEffect(() => {
        if (id !== null) {
            const controller = new AbortController()
            getHost(id, { signal: controller.signal })
            return () => controller.abort()
        }
    }, [id])
    
    async function createHost(host) {
        setLoading(true)
        setErrors({})
    
        return axios.post('super-admin/hosts', host)
        .then(() => navigate(route('hosts.index')))
        .catch(error => {
            if (error.response.status === 422) {
                setErrors(error.response.data.errors)
            }
        })
        .finally(() => setLoading(false))
    }
    
    async function getHost(id, { signal } = {}) {
        setLoading(true)
    
        return axios.get(`super-admin/hosts/${id}`, { signal })
        .then(response => setData(response.data.data))
        .catch(() => {})
        .finally(() => setLoading(false))
    }
    
    async function updateHost(host) {
        setLoading(true)
        setErrors({})
    
        return axios.put(`super-admin/hosts/${host.id}`, host)
        .then(() => navigate(route('hosts.index')))
        .catch(error => {
            if (error.response.status === 422) {
                setErrors(error.response.data.errors)
            }
        })
        .finally(() => setLoading(false))
    }
    
    async function destroyHost(host) {
        return axios.delete(`super-admin/hosts/${host.id}`)
    }
    
    return {
        host: { data, setData, errors, loading },
        createHost,
        updateHost,
        destroyHost,
    }
}