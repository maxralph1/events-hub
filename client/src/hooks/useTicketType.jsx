import { useState, useEffect } from 'react'
import { useNavigate } from 'react-router-dom'
import { route } from '@/routes'
 
export function useTicketType(id = null) {
    const [errors, setErrors] = useState({})
    const [loading, setLoading] = useState(false)
    const [data, setData] = useState({})
    const navigate = useNavigate()
    
    useEffect(() => {
        if (id !== null) {
            const controller = new AbortController()
            getTicketType(id, { signal: controller.signal })
            return () => controller.abort()
        }
    }, [id])
    
    async function createTicketType(ticketType) {
        setLoading(true)
        setErrors({})
    
        return axios.post('super-admin/ticket-types', ticketType)
        .then(() => navigate(route('ticket-types.index')))
        .catch(error => {
            if (error.response.status === 422) {
                setErrors(error.response.data.errors)
            }
        })
        .finally(() => setLoading(false))
    }
    
    async function getTicketType(id, { signal } = {}) {
        setLoading(true)
    
        return axios.get(`super-admin/ticket-types/${id}`, { signal })
        .then(response => setData(response.data.data))
        .catch(() => {})
        .finally(() => setLoading(false))
    }
    
    async function updateTicketType(ticketType) {
        setLoading(true)
        setErrors({})
    
        return axios.put(`super-admin/ticket-types/${ticketType.id}`, ticketType)
        .then(() => navigate(route('ticket-types.index')))
        .catch(error => {
            if (error.response.status === 422) {
                setErrors(error.response.data.errors)
            }
        })
        .finally(() => setLoading(false))
    }
    
    async function destroyTicketType(ticketType) {
        return axios.delete(`super-admin/ticket-types/${ticketType.id}`)
    }
    
    return {
        ticketType: { data, setData, errors, loading },
        createTicketType,
        updateTicketType,
        destroyTicketType,
    }
}