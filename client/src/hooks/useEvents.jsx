import { useState, useEffect } from 'react'
 
export function useEvents() {
    const [events, setEvents] = useState([])
    
    useEffect(() => {
        const controller = new AbortController()
        getEvents({ signal: controller.signal })
        return () => { controller.abort() }
    }, [])
    
    async function getEvents({ signal } = {}) {
        return axios.get('events', { signal })
        .then(response => setEvents(response.data.data))
        .catch(() => {})
    }
    
    return { events, getEvents }
}