import { useState, useEffect } from 'react'
import { useNavigate } from 'react-router-dom'
import { route } from '@/routes'
 
export function useEventHall(id = null) {
    const [errors, setErrors] = useState({})
    const [loading, setLoading] = useState(false)
    const [data, setData] = useState({})
    const navigate = useNavigate()
    
    useEffect(() => {
        if (id !== null) {
            const controller = new AbortController()
            getEventHall(id, { signal: controller.signal })
            return () => controller.abort()
        }
    }, [id])
    
    async function createEventHall(eventHall) {
        setLoading(true)
        setErrors({})
    
        return axios.post('super-admin/event-halls', eventHall)
        .then(() => navigate(route('event-halls.index')))
        .catch(error => {
            if (error.response.status === 422) {
                setErrors(error.response.data.errors)
            }
        })
        .finally(() => setLoading(false))
    }
    
    async function getEventHall(id, { signal } = {}) {
        setLoading(true)
    
        return axios.get(`super-admin/event-halls/${id}`, { signal })
        .then(response => setData(response.data.data))
        .catch(() => {})
        .finally(() => setLoading(false))
    }
    
    async function updateEventHall(eventHall) {
        setLoading(true)
        setErrors({})
    
        return axios.put(`super-admin/event-halls/${eventHall.id}`, eventHall)
        .then(() => navigate(route('event-halls.index')))
        .catch(error => {
            if (error.response.status === 422) {
                setErrors(error.response.data.errors)
            }
        })
        .finally(() => setLoading(false))
    }
    
    async function destroyEventHall(eventHall) {
        return axios.delete(`super-admin/event-halls/${eventHall.id}`)
    }
    
    return {
        eventHall: { data, setData, errors, loading },
        createEventHall,
        updateEventHall,
        destroyEventHall,
    }
}