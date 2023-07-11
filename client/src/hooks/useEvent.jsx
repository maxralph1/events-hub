import { useState, useEffect } from 'react'
import { useNavigate } from 'react-router-dom'
import { route } from '@/routes'
 
export function useEvent(id = null) {
    const [errors, setErrors] = useState({})
    const [loading, setLoading] = useState(false)
    const [data, setData] = useState({})
    const navigate = useNavigate()
    
    useEffect(() => {
        if (id !== null) {
            const controller = new AbortController()
            getEvent(id, { signal: controller.signal })
            return () => controller.abort()
        }
    }, [id])
    
    async function createEvent(event) {
        setLoading(true)
        setErrors({})
    
        return axios.post('super-admin/events', event)
        .then(() => navigate(route('events.index')))
        .catch(error => {
            if (error.response.status === 422) {
                setErrors(error.response.data.errors)
            }
        })
        .finally(() => setLoading(false))
    }
    
    async function getEvent(id, { signal } = {}) {
        setLoading(true)
    
        return axios.get(`super-admin/events/${id}`, { signal })
        .then(response => setData(response.data.data))
        .catch(() => {})
        .finally(() => setLoading(false))
    }
    
    async function updateEvent(event) {
        setLoading(true)
        setErrors({})
    
        return axios.put(`super-admin/events/${event.id}`, event)
        .then(() => navigate(route('events.index')))
        .catch(error => {
            if (error.response.status === 422) {
                setErrors(error.response.data.errors)
            }
        })
        .finally(() => setLoading(false))
    }
    
    async function destroyEvent(event) {
        return axios.delete(`super-admin/events/${event.id}`)
    }
    
    return {
        event: { data, setData, errors, loading },
        createEvent,
        updateEvent,
        destroyEvent,
    }
}