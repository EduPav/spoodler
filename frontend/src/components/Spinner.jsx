import RingLoader from "react-spinners/RingLoader";

const Spinner = ({ loading }) => {
    return (
        <div className="flex justify-center items-center"
        style={{ height: "calc(100vh - 300px)" }}>
            <RingLoader
                loading={loading}
                size={150}
                color="#0077FF"
            />
        </div>
    );
};

export default Spinner;