const { GoogleGenerativeAI } = require("@google/generative-ai");

const genAI = new GoogleGenerativeAI({apiKey: "AIzaSyB-E4xnfie4JXLWf2C0y1WK6k07LLrntw0"});
const model = genAI.getGenerativeModel({ model: "gemini-1.5-flash" });
const generate = async (question) => {
    try {
        const result = await model.generateContent({
            prompt: question
        });
        const response = result.response;
        console.log(response.text());
        return response.text();
    } catch (error) {
        console.log("response error", error);
    }
};

// Example usage
generate("Explain how AI works");