import { useParams } from 'react-router-dom'
import { route } from '@/routes'
import { useEventHall } from '@/hooks/useEventHall'
 
function EventHall() {
    const params = useParams()
    const { eventHall } = useEventHall(params.id)
    
    return (
        <div className="">
    
            <h1 className="">EventHall <b>{ eventHall.name }</b></h1>

            <p>Name: { eventHall.data.name }</p>
    
            <p>Description: { eventHall.data.description }</p>
    
            <div className="">
                <Link to={ route('event-halls.index') } className="">
                    All Events
                </Link>
            </div>
        </div>
    )
}
 
export default EventHall