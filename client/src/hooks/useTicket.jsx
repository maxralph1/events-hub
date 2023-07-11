import { useState, useEffect } from 'react'
import { useNavigate } from 'react-router-dom'
import { route } from '@/routes'
 
export function useTicket(id = null) {
    const [errors, setErrors] = useState({})
    const [loading, setLoading] = useState(false)
    const [data, setData] = useState({})
    const navigate = useNavigate()
    
    useEffect(() => {
        if (id !== null) {
            const controller = new AbortController()
            getTicket(id, { signal: controller.signal })
            return () => controller.abort()
        }
    }, [id])
    
    async function createTicket(ticket) {
        setLoading(true)
        setErrors({})
    
        return axios.post('super-admin/tickets', ticket)
        .then(() => navigate(route('tickets.index')))
        .catch(error => {
            if (error.response.status === 422) {
                setErrors(error.response.data.errors)
            }
        })
        .finally(() => setLoading(false))
    }
    
    async function getTicket(id, { signal } = {}) {
        setLoading(true)
    
        return axios.get(`super-admin/tickets/${id}`, { signal })
        .then(response => setData(response.data.data))
        .catch(() => {})
        .finally(() => setLoading(false))
    }
    
    async function updateTicket(ticket) {
        setLoading(true)
        setErrors({})
    
        return axios.put(`super-admin/tickets/${ticket.id}`, ticket)
        .then(() => navigate(route('tickets.index')))
        .catch(error => {
            if (error.response.status === 422) {
                setErrors(error.response.data.errors)
            }
        })
        .finally(() => setLoading(false))
    }
    
    async function destroyTicket(ticket) {
        return axios.delete(`super-admin/tickets/${ticket.id}`)
    }
    
    return {
        ticket: { data, setData, errors, loading },
        createTicket,
        updateTicket,
        destroyTicket,
    }
}