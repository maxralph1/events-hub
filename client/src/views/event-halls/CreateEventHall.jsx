import { useNavigate } from 'react-router-dom'
import { useEventHall } from '@/hooks/useEventHall'
import { route } from '@/routes'
import ValidationError from '@/components/ValidationError'
import IconSpinner from '@/components/IconSpinner'
 
function CreateEventHall() {
    const { eventHall, createEventHall } = useEventHall()
    const navigate = useNavigate()
    
    async function handleSubmit(event) {
        event.preventDefault()
    
        await createEventHall(eventHall.data)
    }
    
    return (
        <form onSubmit={ handleSubmit } noValidate>
        <div className="">
    
            <h1 className="">Add EventHall</h1>
    
            <div className="">
            <label htmlFor="name" className="">Name</label>
            <input
                id="name"
                name="name"
                type="text"
                value={ eventHall.data.name ?? '' }
                onChange={ event => eventHall.setData({
                ...eventHall.data,
                name: event.target.value,
                }) }
                className=""
                disabled={ eventHall.loading }
            />
            <ValidationError errors={ eventHall.errors } field="name" />
            </div>
    
            <div className="">
            <label htmlFor="description" className="">Description</label>
            <input
                id="description"
                name="description"
                type="text"
                value={ eventHall.data.description ?? '' }
                onChange={ event => eventHall.setData({
                ...eventHall.data,
                description: event.target.value,
                }) }
                className=""
                disabled={ eventHall.loading }
            />
            <ValidationError errors={ eventHall.errors } field="description" />
            </div>
    
            <div className="border-t h-[1px] my-6"></div>
    
            <div className="">
            <button
                type="submit"
                className=""
                disabled={ eventHall.loading }
            >
                { eventHall.loading && <IconSpinner /> }
                Save EventHall
            </button>
    
            <button
                type="button"
                className=""
                disabled={ eventHall.loading }
                onClick={ () => navigate(route('eventHalls.index')) }
            >
                <span>Cancel</span>
            </button>
            </div>
        </div>
        </form>
    )
}
 
export default CreateEventHall