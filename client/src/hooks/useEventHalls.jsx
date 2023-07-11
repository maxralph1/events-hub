import { useState, useEffect } from 'react'
 
export function useEventHalls() {
    const [eventHalls, setEventHalls] = useState([])
    
    useEffect(() => {
        const controller = new AbortController()
        getEventHalls({ signal: controller.signal })
        return () => { controller.abort() }
    }, [])
    
    async function getEventHalls({ signal } = {}) {
        return axios.get('super-admin/event-halls', { signal })
        .then(response => setEventHalls(response.data.data))
        .catch(() => {})
    }
    
    return { eventHalls, getEventHalls }
}