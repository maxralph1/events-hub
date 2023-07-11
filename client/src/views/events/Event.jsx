import { Link, useParams } from 'react-router-dom'
import { route } from '@/routes'
import { useEvent } from '@/hooks/useEvent'
 
function Event() {
    const params = useParams()
    const { event } = useEvent(params.id)
    
    return (
        <div className="">
    
            <h1 className="">Event <b>{ event.data.title }</b></h1>

            <p>ID: { event.data.id }</p>

            <p>Title: { event.data.title }</p>
    
            <p>Description: { event.data.description }</p>
    
            <p>Start: { event.data.start_date } { event.data.start_time }</p>
    
            <p>End: { event.data.end_date } { event.data.end_time }</p>
    
            <p>Event-Hall: { event.data.event-hall.name }</p>
    
            <p>Host: { event.data.host.name }</p>
    
            <p>User: { event.data.user.name }</p>
    
            <div className=""></div>
    
            <div className="">
                <Link to={ route('events.index') } className="">
                    All Events
                </Link>
            </div>
        </div>
    )
}
 
export default Event