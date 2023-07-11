import { useState, useEffect } from 'react'
import { useNavigate } from 'react-router-dom'
import { route } from '@/routes'
 
export function useTicketVerification(id = null) {
    const [errors, setErrors] = useState({})
    const [loading, setLoading] = useState(false)
    const [data, setData] = useState({})
    const navigate = useNavigate()
    
    useEffect(() => {
        if (id !== null) {
            const controller = new AbortController()
            getTicketVerification(id, { signal: controller.signal })
            return () => controller.abort()
        }
    }, [id])
    
    async function createTicketVerification(ticketVerification) {
        setLoading(true)
        setErrors({})
    
        return axios.post('super-admin/ticket-verifications', ticketVerification)
        .then(() => navigate(route('ticket-verifications.index')))
        .catch(error => {
            if (error.response.status === 422) {
                setErrors(error.response.data.errors)
            }
        })
        .finally(() => setLoading(false))
    }
    
    async function getTicketVerification(id, { signal } = {}) {
        setLoading(true)
    
        return axios.get(`super-admin/ticket-verifications/${id}`, { signal })
        .then(response => setData(response.data.data))
        .catch(() => {})
        .finally(() => setLoading(false))
    }
    
    async function updateTicketVerification(ticketVerification) {
        setLoading(true)
        setErrors({})
    
        return axios.put(`super-admin/ticket-verifications/${ticketVerification.id}`, ticketVerification)
        .then(() => navigate(route('ticket-verifications.index')))
        .catch(error => {
            if (error.response.status === 422) {
                setErrors(error.response.data.errors)
            }
        })
        .finally(() => setLoading(false))
    }
    
    async function destroyTicketVerification(ticketVerification) {
        return axios.delete(`super-admin/ticket-verifications/${ticketVerification.id}`)
    }
    
    return {
        ticketVerification: { data, setData, errors, loading },
        createTicketVerification,
        updateTicketVerification,
        destroyTicketVerification,
    }
}