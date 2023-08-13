import React from 'react';
import ReactDOM from 'react-dom/client';

function Example({title}) {
    // const names = ['Budi', 'Andi', 'Joko'];
    const [number, setNumber] = React.useState(0);

    function handleClick(value) {
        setNumber(value === 0 ? 0 : (number + value));
    }

    return (
        <div className="container my-3">
            <div className="row justify-content-center">
                <div className="col-md-8">
                    <button onClick={() => setNumber((number - 1) < 0 ? 'done' : number - 1)} className="btn btn-primary px-4 me-3" disabled={number === 'done!'}>-</button>

                    <span>{(number)}</span>

                    <button onClick={() => setNumber((number + 1) > 10 ? 'done' : number + 1)} className="btn btn-primary px-4 ms-3" disabled={number === 'done!'}>+</button>

                    <button onClick={() => setNumber(0)} className="btn btn-danger ms-3" disabled={number <= 10 && number >= 0}>Reset</button>
                    {/* <div className="card">
                        <div className="card-header">{title ?? 'Yoooo'} Component</div>

                        <div className="card-body">I'm an {title ?? 'Yoooo'} component!</div>
                    </div> */}
                    {/* <ul>
                        {names.map((item, index) => (
                            <li key={index}>{item}</li>
                        ))}
                    </ul> */}
                    
                </div>
            </div>
        </div>
    );
}



export default Example;

if (document.getElementById('example')) {
    const Index = ReactDOM.createRoot(document.getElementById("example"));

    Index.render(
        <React.StrictMode>
            <>
            <Example />
            </>
        </React.StrictMode>
    )
}
