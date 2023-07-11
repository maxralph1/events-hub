import { useNavigate } from 'react-router-dom'
import { useHost } from '@/hooks/useHost'
import { route } from '@/routes'
import ValidationError from '@/components/ValidationError'
import IconSpinner from '@/components/IconSpinner'
 
function CreateHost() {
    const { host, createHost } = useHost()
    const navigate = useNavigate()
    
    async function handleSubmit(event) {
        event.preventDefault()
    
        await createHost(host.data)
    }
    
    return (
        <form onSubmit={ handleSubmit } noValidate>
        <div className="">
    
            <h1 className="">Add Host</h1>
    
            <div className="">
            <label htmlFor="name" className="">Name</label>
            <input
                id="name"
                name="name"
                type="text"
                value={ host.data.name ?? '' }
                onChange={ event => host.setData({
                ...host.data,
                name: event.target.value,
                }) }
                className=""
                disabled={ host.loading }
            />
            <ValidationError errors={ host.errors } field="name" />
            </div>
    
            <div className="">
            <label htmlFor="description" className="">Description</label>
            <input
                id="description"
                name="description"
                type="text"
                value={ host.data.description ?? '' }
                onChange={ event => host.setData({
                ...host.data,
                description: event.target.value,
                }) }
                className=""
                disabled={ host.loading }
            />
            <ValidationError errors={ host.errors } field="description" />
            </div>
    
            <div className="border-t h-[1px] my-6"></div>
    
            <div className="">
            <button
                type="submit"
                className=""
                disabled={ host.loading }
            >
                { host.loading && <IconSpinner /> }
                Save Host
            </button>
    
            <button
                type="button"
                className=""
                disabled={ host.loading }
                onClick={ () => navigate(route('hosts.index')) }
            >
                <span>Cancel</span>
            </button>
            </div>
        </div>
        </form>
    )
}
 
export default CreateHost